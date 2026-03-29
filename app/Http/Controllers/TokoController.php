<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\BarangKeluar;
use App\Models\TransaksiPembelian;
use App\Models\DetailTransaksiPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class TokoController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    // ─── Toko ────────────────────────────────────────────────────────────────

    public function index()
    {
        $obat           = Obat::where('status', true)->where('stok', '>', 0)->paginate(12);
        $totalKeranjang = count(session()->get('keranjang', []));

        return view('user.beli-obat.index', compact('obat', 'totalKeranjang'));
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
            $keranjang[$obat->id]['jumlah']   += $jumlah;
            $keranjang[$obat->id]['subtotal']  = $keranjang[$obat->id]['jumlah'] * $obat->harga;
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
            $keranjang[$request->id_obat]['jumlah']   = $request->jumlah;
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

        // Simpan header transaksi
        $transaksi = TransaksiPembelian::create([
            'kode_transaksi'    => $kode,
            'user_id'           => auth()->id(),
            'total_harga'       => $total,
            'status'            => 'pending',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_telepon'        => $request->no_telepon,
            'catatan'           => $request->catatan,
            'order_id'          => $kode,
        ]);

        // Simpan detail transaksi
        // BarangKeluar & pengurangan stok TIDAK dilakukan di sini,
        // melainkan di callback setelah pembayaran berhasil.
        foreach ($keranjang as $item) {
            DetailTransaksiPembelian::create([
                'transaksi_pembelian_id' => $transaksi->id,
                'id_obat'                => $item['id_obat'],
                'jumlah'                 => $item['jumlah'],
                'harga_satuan'           => $item['harga'],
                'subtotal'               => $item['subtotal'],
            ]);
        }

        // Buat Snap Token Midtrans
        $params = [
            'transaction_details' => [
                'order_id'     => $kode,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
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

        return view('user.beli-obat.payment', compact('transaksi', 'snapToken'));
    }

    // ─── Midtrans Callback ───────────────────────────────────────────────────

    public function callback(Request $request)
    {
        $notif   = new Notification();
        $status  = $notif->transaction_status;
        $fraud   = $notif->fraud_status;
        $orderId = $notif->order_id;

        $transaksi = TransaksiPembelian::where('order_id', $orderId)
            ->with('details')
            ->firstOrFail();

        if ($status === 'capture' || $status === 'settlement') {

            $isPaid = $status === 'settlement'
                || ($status === 'capture' && $fraud !== 'challenge');

            if ($isPaid && $transaksi->status !== 'dibayar') {
                $transaksi->status = 'dibayar';

                // ✅ Catat BarangKeluar (kode PJ-) & kurangi stok setelah bayar
                foreach ($transaksi->details as $detail) {
                    BarangKeluar::create([
                        'kode'           => 'PJ-' . $transaksi->kode_transaksi . '-' . $detail->id_obat,
                        'id_obat'        => $detail->id_obat,
                        'jumlah'         => $detail->jumlah,
                        'tanggal_keluar' => now(),
                        'deskripsi'      => 'Penjualan toko online - ' . $transaksi->kode_transaksi
                                            . ' oleh ' . optional($transaksi->user)->name,
                    ]);

                    Obat::where('id', $detail->id_obat)
                        ->decrement('stok', $detail->jumlah);
                }
            } elseif (! $isPaid) {
                $transaksi->status = 'pending';
            }

        } elseif (in_array($status, ['cancel', 'deny', 'expire'])) {

            // Kembalikan stok & hapus BarangKeluar hanya jika sebelumnya sudah dibayar
            if ($transaksi->status === 'dibayar') {
                foreach ($transaksi->details as $detail) {
                    Obat::where('id', $detail->id_obat)
                        ->increment('stok', $detail->jumlah);

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

        $transaksi->payment_type      = $notif->payment_type;
        $transaksi->transaction_id    = $notif->transaction_id;
        $transaksi->tanggal_bayar     = now();
        $transaksi->midtrans_response = json_encode($notif);
        $transaksi->save();

        return response()->json(['status' => 'ok']);
    }

    // ─── Riwayat ─────────────────────────────────────────────────────────────

    public function riwayat()
    {
        $transaksi = TransaksiPembelian::where('user_id', auth()->id())
            ->with('details.obat')
            ->latest()
            ->paginate(10);

        return view('user.beli-obat.riwayat', compact('transaksi'));
    }
}