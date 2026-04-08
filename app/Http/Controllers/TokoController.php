<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\BarangKeluar;
use App\Models\TransaksiPembelian;
use App\Models\DetailTransaksiPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Midtrans\Transaction;

class TokoController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized', true);
        Config::$is3ds        = config('midtrans.is_3ds', true);
    }

    // ─── Toko ────────────────────────────────────────────────────────────────

    public function index()
    {
        $search = trim((string) request('search'));

        $obat = Obat::where('status', true)
            ->where('stok', '>', 0)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('nama_obat', 'like', "%{$search}%")
                        ->orWhere('kode_obat', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->paginate(12)
            ->withQueryString();

        $totalKeranjang = count(session()->get('keranjang', []));

        return view('user.beli-obat.index', compact('obat', 'totalKeranjang', 'search'));
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id);

        return view('user.beli-obat.show', compact('obat'));
    }

    // ─── Keranjang ───────────────────────────────────────────────────────────

    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $total     = collect($keranjang)->sum('subtotal');

        return view('user.beli-obat.keranjang', compact('keranjang', 'total'));
    }

    public function tambahKeranjang(Request $request)
    {
        $obat      = Obat::findOrFail($request->id_obat);
        $keranjang = session()->get('keranjang', []);
        $jumlah    = $request->jumlah ?? 1;

        if (isset($keranjang[$obat->id])) {
            $keranjang[$obat->id]['jumlah']  += $jumlah;
            $keranjang[$obat->id]['subtotal'] = $keranjang[$obat->id]['jumlah'] * $obat->harga;
        } else {
            $keranjang[$obat->id] = [
                'id_obat'   => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'harga'     => $obat->harga,
                'jumlah'    => $jumlah,
                'subtotal'  => $jumlah * $obat->harga,
                'satuan'    => $obat->satuan,
                'foto'      => $obat->foto,
            ];
        }

        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Obat berhasil ditambahkan ke keranjang!');
    }

    public function beliSekarang(Request $request)
    {
        $obat   = Obat::findOrFail($request->id_obat);
        $jumlah = $request->jumlah ?? 1;

        session()->put('keranjang', [
            $obat->id => [
                'id_obat'   => $obat->id,
                'nama_obat' => $obat->nama_obat,
                'harga'     => $obat->harga,
                'jumlah'    => $jumlah,
                'subtotal'  => $jumlah * $obat->harga,
                'satuan'    => $obat->satuan,
                'foto'      => $obat->foto,
            ],
        ]);

        return redirect()->route('toko.checkout');
    }

    public function updateKeranjang(Request $request)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$request->id_obat])) {
            $keranjang[$request->id_obat]['jumlah']  = $request->jumlah;
            $keranjang[$request->id_obat]['subtotal'] = $request->jumlah * $keranjang[$request->id_obat]['harga'];
        }

        session()->put('keranjang', $keranjang);

        return back();
    }

    public function hapusKeranjang($id)
    {
        $keranjang = session()->get('keranjang', []);
        unset($keranjang[$id]);
        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Obat dihapus dari keranjang.');
    }

    // ─── Checkout ────────────────────────────────────────────────────────────

    public function checkout()
    {
        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('toko.keranjang');
        }

        $total = collect($keranjang)->sum('subtotal');

        return view('user.beli-obat.checkout', compact('keranjang', 'total'));
    }

    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'no_telepon'        => 'required|string',
        ]);

        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('toko.keranjang');
        }

        $total = collect($keranjang)->sum('subtotal');
        $kode  = 'TRX-' . strtoupper(Str::random(8));

        $transaksi = TransaksiPembelian::create([
            'kode_transaksi'    => $kode,
            'user_id'           => Auth::id(),
            'total_harga'       => $total,
            'status'            => 'pending',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_telepon'        => $request->no_telepon,
            'catatan'           => $request->catatan,
            'order_id'          => $kode,
        ]);

        foreach ($keranjang as $item) {
            DetailTransaksiPembelian::create([
                'transaksi_pembelian_id' => $transaksi->id,
                'id_obat'                => $item['id_obat'],
                'jumlah'                 => $item['jumlah'],
                'harga_satuan'           => $item['harga'],
                'subtotal'               => $item['subtotal'],
            ]);
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $kode,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => $request->no_telepon,
            ],
            'item_details' => collect($keranjang)->map(fn ($item) => [
                'id'       => $item['id_obat'],
                'price'    => (int) $item['harga'],
                'quantity' => $item['jumlah'],
                'name'     => $item['nama_obat'],
            ])->values()->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);
        $transaksi->update(['snap_token' => $snapToken]);

        session()->forget('keranjang');

        return redirect()->route('toko.pembayaran', $transaksi->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');
    }

    // ─── Pembayaran ──────────────────────────────────────────────────────────

    public function pembayaran($id)
    {
        $transaksi = TransaksiPembelian::where('user_id', Auth::id())
            ->with('details.obat')
            ->findOrFail($id);

        if ($transaksi->status === 'pending') {
            $this->syncStatusFromMidtrans($transaksi);
            $transaksi->refresh()->load('details.obat');
        }

        if ($transaksi->status !== 'pending') {
            return redirect()->route('toko.riwayat')
                ->with('info', 'Transaksi ini sudah diproses atau kadaluarsa.');
        }

        if (empty($transaksi->snap_token)) {
            $params = [
                'transaction_details' => [
                    'order_id'     => $transaksi->kode_transaksi,
                    'gross_amount' => (int) $transaksi->total_harga,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email'      => Auth::user()->email,
                    'phone'      => $transaksi->no_telepon,
                ],
                'item_details' => $transaksi->details->map(fn ($d) => [
                    'id'       => $d->id_obat,
                    'price'    => (int) $d->harga_satuan,
                    'quantity' => $d->jumlah,
                    'name'     => $d->obat->nama_obat,
                ])->values()->toArray(),
            ];

            $snapToken = Snap::getSnapToken($params);
            $transaksi->update(['snap_token' => $snapToken]);
        }

        $snapToken = $transaksi->snap_token;

        return view('user.beli-obat.pembayaran', compact('transaksi', 'snapToken'));
    }

    // ─── Midtrans Callback ───────────────────────────────────────────────────

    public function callback(Request $request)
    {
        $payload = $request->json()->all();

        if (empty($payload)) {
            $payload = json_decode($request->getContent(), true) ?: [];
        }

        if (empty($payload)) {
            $notif = new Notification();
            $payload = json_decode(json_encode($notif), true) ?: [];
        }

        $orderId = $payload['order_id'] ?? null;
        $status = $payload['transaction_status'] ?? null;
        $fraud = $payload['fraud_status'] ?? null;

        if (! $orderId || ! $status) {
            Log::warning('Midtrans callback payload tidak valid', [
                'payload' => $payload,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Payload Midtrans tidak valid',
            ], 422);
        }

        if (! $this->isValidMidtransSignature($payload)) {
            Log::warning('Midtrans signature tidak valid', [
                'order_id' => $orderId,
                'payload' => $payload,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Signature Midtrans tidak valid',
            ], 403);
        }

        Log::info('Midtrans callback diterima', [
            'order_id' => $orderId,
            'transaction_status' => $status,
            'payment_type' => $payload['payment_type'] ?? null,
            'transaction_id' => $payload['transaction_id'] ?? null,
        ]);

        $transaksi = TransaksiPembelian::where('order_id', $orderId)
            ->with('details')
            ->firstOrFail();

        $this->applyMidtransStatus($transaksi, $payload, $status, $fraud);

        return response()->json(['status' => 'ok']);
    }

    // ─── Riwayat ─────────────────────────────────────────────────────────────

    public function riwayat()
    {
        $transaksi = TransaksiPembelian::where('user_id', Auth::id())
            ->with('details.obat')
            ->latest()
            ->paginate(10);

        $transaksi->getCollection()->each(function ($item) {
            if ($item->status === 'pending') {
                $this->syncStatusFromMidtrans($item);
                $item->refresh()->load('details.obat');
            }
        });

        return view('user.beli-obat.riwayat', compact('transaksi'));
    }

    protected function syncStatusFromMidtrans(TransaksiPembelian $transaksi): void
    {
        if (empty($transaksi->order_id)) {
            return;
        }

        try {
            $response = Transaction::status($transaksi->order_id);
            $payload = json_decode(json_encode($response), true) ?: [];
            $status = $payload['transaction_status'] ?? null;
            $fraud = $payload['fraud_status'] ?? null;

            if ($status) {
                $this->applyMidtransStatus($transaksi->fresh('details'), $payload, $status, $fraud);
            }
        } catch (\Throwable $e) {
            Log::warning('Gagal sinkron status Midtrans', [
                'order_id' => $transaksi->order_id,
                'message' => $e->getMessage(),
            ]);

            report($e);
        }
    }

    protected function applyMidtransStatus(
        TransaksiPembelian $transaksi,
        array $payload,
        string $status,
        ?string $fraud = null
    ): void {
        if ($status === 'capture' || $status === 'settlement') {
            $isPaid = $status === 'settlement'
                || ($status === 'capture' && $fraud !== 'challenge');

            if ($isPaid && $transaksi->status !== 'dibayar') {
                $transaksi->status = 'dibayar';
                $transaksi->tanggal_bayar = now();

                foreach ($transaksi->details as $detail) {
                    BarangKeluar::firstOrCreate(
                        ['kode' => 'PJ-' . $transaksi->kode_transaksi . '-' . $detail->id_obat],
                        [
                            'id_obat' => $detail->id_obat,
                            'jumlah' => $detail->jumlah,
                            'tanggal_keluar' => now(),
                            'deskripsi' => 'Penjualan toko online - ' . $transaksi->kode_transaksi
                                . ' oleh ' . optional($transaksi->user)->name,
                        ]
                    );

                    $obat = Obat::find($detail->id_obat);
                    if ($obat && $obat->stok >= $detail->jumlah) {
                        $obat->decrement('stok', $detail->jumlah);
                    }
                }
            } elseif (! $isPaid) {
                $transaksi->status = 'pending';
            }
        } elseif (in_array($status, ['cancel', 'deny', 'expire'], true)) {
            if ($transaksi->status === 'dibayar') {
                foreach ($transaksi->details as $detail) {
                    Obat::where('id', $detail->id_obat)->increment('stok', $detail->jumlah);
                    BarangKeluar::where(
                        'kode',
                        'PJ-' . $transaksi->kode_transaksi . '-' . $detail->id_obat
                    )->delete();
                }
            }

            $transaksi->status = $status === 'expire' ? 'expired' : 'dibatalkan';
        } elseif ($status === 'pending') {
            $transaksi->status = 'pending';
        }

        $transaksi->payment_type = $payload['payment_type'] ?? $transaksi->payment_type;
        $transaksi->transaction_id = $payload['transaction_id'] ?? $transaksi->transaction_id;
        $transaksi->midtrans_response = json_encode($payload);
        $transaksi->save();
    }

    protected function isValidMidtransSignature(array $payload): bool
    {
        if (! isset($payload['signature_key'], $payload['order_id'], $payload['status_code'], $payload['gross_amount'])) {
            return false;
        }

        $expectedSignature = hash(
            'sha512',
            $payload['order_id']
            . $payload['status_code']
            . $payload['gross_amount']
            . config('midtrans.server_key')
        );

        return hash_equals($expectedSignature, $payload['signature_key']);
    }
}
