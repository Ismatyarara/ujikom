<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksiPembelian;
use App\Models\Obat;
use App\Models\TransaksiPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class TokoApiController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized', true);
        Config::$is3ds        = config('midtrans.is_3ds', true);
    }

    // GET /api/obat
    public function index(Request $request)
    {
        $obat = Obat::where('status', true)
            ->where('stok', '>', 0)
            ->when($request->search, fn($q) =>
                $q->where('nama_obat', 'like', "%{$request->search}%")
                  ->orWhere('kode_obat', 'like', "%{$request->search}%")
            )
            ->paginate(12);

        return response()->json([
            'success' => true,
            'data'    => $obat->map(fn($o) => $this->formatObat($o)),
            'meta'    => [
                'current_page' => $obat->currentPage(),
                'last_page'    => $obat->lastPage(),
                'total'        => $obat->total(),
            ],
        ]);
    }

    // GET /api/obat/{id}
    public function show($id)
    {
        $obat = Obat::where('status', true)->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $this->formatObat($obat),
        ]);
    }

    // POST /api/toko/beli
    public function beli(Request $request)
    {
        $request->validate([
            'items'              => 'required|array|min:1',
            'items.*.id_obat'   => 'required|exists:obat,id',
            'items.*.jumlah'    => 'required|integer|min:1',
            'alamat_pengiriman' => 'required|string',
            'no_telepon'        => 'required|string',
            'catatan'           => 'nullable|string',
        ]);

        // Validasi stok
        foreach ($request->items as $item) {
            $obat = Obat::findOrFail($item['id_obat']);
            if ($obat->stok < $item['jumlah']) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok {$obat->nama_obat} tidak mencukupi (tersisa {$obat->stok})",
                ], 422);
            }
        }

        $kode  = 'TRX-' . strtoupper(Str::random(8));
        $total = 0;
        $itemDetails = [];

        foreach ($request->items as $item) {
            $obat     = Obat::findOrFail($item['id_obat']);
            $subtotal = $obat->harga * $item['jumlah'];
            $total   += $subtotal;

            $itemDetails[] = [
                'obat'     => $obat,
                'jumlah'   => $item['jumlah'],
                'subtotal' => $subtotal,
            ];
        }

        $transaksi = TransaksiPembelian::create([
            'kode_transaksi'    => $kode,
            'order_id'          => $kode,
            'user_id'           => Auth::id(),
            'total_harga'       => $total,
            'status'            => 'pending',
            'alamat_pengiriman' => $request->alamat_pengiriman,
            'no_telepon'        => $request->no_telepon,
            'catatan'           => $request->catatan,
        ]);

        foreach ($itemDetails as $item) {
            DetailTransaksiPembelian::create([
                'transaksi_pembelian_id' => $transaksi->id,
                'id_obat'                => $item['obat']->id,
                'jumlah'                 => $item['jumlah'],
                'harga_satuan'           => $item['obat']->harga,
                'subtotal'               => $item['subtotal'],
            ]);
        }

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id'     => $kode,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
                'phone'      => $request->no_telepon,
            ],
            'item_details' => collect($itemDetails)->map(fn($i) => [
                'id'       => $i['obat']->id,
                'price'    => (int) $i['obat']->harga,
                'quantity' => $i['jumlah'],
                'name'     => $i['obat']->nama_obat,
            ])->values()->toArray(),
        ]);

        $transaksi->update(['snap_token' => $snapToken]);

        return response()->json([
            'success'    => true,
            'message'    => 'Transaksi berhasil dibuat',
            'data'       => [
                'transaksi_id'   => $transaksi->id,
                'kode_transaksi' => $kode,
                'total_harga'    => $total,
                'snap_token'     => $snapToken,
            ],
        ], 201);
    }

    // GET /api/toko/riwayat
    public function riwayat()
    {
        $transaksi = TransaksiPembelian::where('user_id', Auth::id())
            ->with('details.obat')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data'    => $transaksi->map(fn($t) => $this->formatTransaksi($t)),
            'meta'    => [
                'current_page' => $transaksi->currentPage(),
                'last_page'    => $transaksi->lastPage(),
                'total'        => $transaksi->total(),
            ],
        ]);
    }

    // GET /api/toko/riwayat/{id}
    public function detailTransaksi($id)
    {
        $transaksi = TransaksiPembelian::where('user_id', Auth::id())
            ->with('details.obat')
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $this->formatTransaksi($transaksi),
        ]);
    }

    //  Helpers 

    private function formatObat(Obat $obat): array
    {
        return [
            'id'          => $obat->id,
            'kode_obat'   => $obat->kode_obat,
            'nama_obat'   => $obat->nama_obat,
            'deskripsi'   => $obat->deskripsi,
            'aturan_pakai'=> $obat->aturan_pakai,
            'efek_samping'=> $obat->efek_samping,
            'stok'        => $obat->stok,
            'harga'       => $obat->harga,
            'satuan'      => $obat->satuan,
            'foto_url' => $obat->foto
                ? asset('storage/' . $obat->foto)
                : null,        ];
    }

    private function formatTransaksi(TransaksiPembelian $t): array
    {
        return [
            'id'                => $t->id,
            'kode_transaksi'    => $t->kode_transaksi,
            'status'            => $t->status,
            'total_harga'       => $t->total_harga,
            'snap_token'        => $t->snap_token,
            'alamat_pengiriman' => $t->alamat_pengiriman,
            'no_telepon'        => $t->no_telepon,
            'catatan'           => $t->catatan,
            'tanggal_bayar'     => $t->tanggal_bayar,
            'created_at'        => $t->created_at,
            'items'             => $t->details->map(fn($d) => [
                'id'          => $d->id,
                'nama_obat'   => $d->obat?->nama_obat,
                'foto_url' => $d->obat?->foto
                ? asset('storage/' . $d->obat->foto)
                : null,                'jumlah'      => $d->jumlah,
                'harga_satuan'=> $d->harga_satuan,
                'subtotal'    => $d->subtotal,
            ]),
        ];
    }
}