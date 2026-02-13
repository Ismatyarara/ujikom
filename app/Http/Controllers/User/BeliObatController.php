<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\TransaksiPembelian;
use App\Models\DetailTransaksiPembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeliObatController extends Controller
{
    // ================= TAMPILAN CARD OBAT =================
    public function index()
    {
        $obat = Obat::where('status', 1)
            ->where('stok', '>', 0)
            ->latest()
            ->get();

        $keranjang = session()->get('keranjang', []);
        $totalKeranjang = count($keranjang);

        return view('user.beli-obat.index', compact('obat', 'totalKeranjang'));
    }

    // ================= DETAIL OBAT =================
    public function show($id)
    {
        $obat = Obat::findOrFail($id);
        return view('user.beli-obat.show', compact('obat'));
    }

    // ================= TAMBAH KE KERANJANG =================
    public function tambahKeranjang(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($id);

        if ($obat->stok < $request->jumlah) {
            return back()->with('error', 'Stok obat tidak mencukupi');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $totalJumlah = $keranjang[$id]['jumlah'] + $request->jumlah;
            
            if ($obat->stok < $totalJumlah) {
                return back()->with('error', 'Stok obat tidak mencukupi');
            }
            
            $keranjang[$id]['jumlah'] = $totalJumlah;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['jumlah'] * $keranjang[$id]['harga'];
        } else {
            $keranjang[$id] = [
                'nama_obat' => $obat->nama_obat,
                'foto' => $obat->foto,
                'harga' => $obat->harga,
                'satuan' => $obat->satuan,
                'jumlah' => $request->jumlah,
                'subtotal' => $obat->harga * $request->jumlah,
            ];
        }

        session()->put('keranjang', $keranjang);

        return back()->with('success', 'Obat berhasil ditambahkan ke keranjang');
    }

    // ================= LIHAT KERANJANG =================
    public function keranjang()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;

        foreach ($keranjang as $item) {
            $total += $item['subtotal'];
        }

        return view('user.beli-obat.keranjang', compact('keranjang', 'total'));
    }

    // ================= UPDATE KERANJANG =================
    public function updateKeranjang(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($id);
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            if ($obat->stok < $request->jumlah) {
                return back()->with('error', 'Stok obat tidak mencukupi');
            }

            $keranjang[$id]['jumlah'] = $request->jumlah;
            $keranjang[$id]['subtotal'] = $keranjang[$id]['harga'] * $request->jumlah;
            session()->put('keranjang', $keranjang);

            return back()->with('success', 'Keranjang berhasil diupdate');
        }

        return back()->with('error', 'Obat tidak ditemukan di keranjang');
    }

    // ================= HAPUS DARI KERANJANG =================
    public function hapusKeranjang($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            unset($keranjang[$id]);
            session()->put('keranjang', $keranjang);
            return back()->with('success', 'Obat berhasil dihapus dari keranjang');
        }

        return back()->with('error', 'Obat tidak ditemukan di keranjang');
    }

    // ================= CHECKOUT =================
    public function checkout()
    {
        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('user.beli-obat.index')->with('error', 'Keranjang kosong');
        }

        $total = array_sum(array_column($keranjang, 'subtotal'));

        return view('user.beli-obat.checkout', compact('keranjang', 'total'));
    }

    // ================= PROSES CHECKOUT =================
    public function prosesCheckout(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'no_telepon' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $keranjang = session()->get('keranjang', []);

        if (empty($keranjang)) {
            return redirect()->route('user.beli-obat.index')->with('error', 'Keranjang kosong');
        }

        DB::beginTransaction();

        try {
            $total = array_sum(array_column($keranjang, 'subtotal'));

            // Validasi stok lagi
            foreach ($keranjang as $id => $item) {
                $obat = Obat::findOrFail($id);
                if ($obat->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$obat->nama_obat} tidak mencukupi");
                }
            }

            // Buat transaksi
            $transaksi = TransaksiPembelian::create([
                'user_id' => auth::id();
                'total_harga' => $total,
                'status' => 'pending',
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'no_telepon' => $request->no_telepon,
                'catatan' => $request->catatan,
            ]);

            // Simpan detail
            foreach ($keranjang as $id => $item) {
                DetailTransaksiPembelian::create([
                    'transaksi_pembelian_id' => $transaksi->id,
                    'id_obat' => $id,
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            DB::commit();

            // Hapus keranjang
            session()->forget('keranjang');

            return redirect()->route('user.beli-obat.pembayaran', $transaksi->id)
                ->with('success', 'Pesanan berhasil dibuat. Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // ================= HALAMAN PEMBAYARAN =================
    public function pembayaran($id)
    {
        $transaksi = TransaksiPembelian::where('user_id', auth()->id())
            ->with('details.obat')
            ->findOrFail($id);

        if (!in_array($transaksi->status, ['pending', 'dibayar'])) {
            return redirect()->route('user.beli-obat.riwayat')
                ->with('info', 'Transaksi ini sudah diproses');
        }

        return view('user.beli-obat.pembayaran', compact('transaksi'));
    }

    // ================= UPLOAD BUKTI TRANSFER =================
    public function uploadBukti(Request $request, $id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $transaksi = TransaksiPembelian::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($transaksi->status != 'pending') {
            return back()->with('error', 'Transaksi ini sudah diproses');
        }

        $buktiPath = $request->file('bukti_transfer')->store('bukti-transfer', 'public');

        $transaksi->update([
            'metode_pembayaran' => $request->metode_pembayaran,
            'bukti_transfer' => $buktiPath,
            'tanggal_bayar' => now(),
            'status' => 'dibayar',
        ]);

        return redirect()->route('user.beli-obat.riwayat')
            ->with('success', 'Bukti transfer berhasil diupload. Menunggu verifikasi staff.');
    }

    // ================= RIWAYAT PEMBELIAN =================
    public function riwayat()
    {
        $transaksi = TransaksiPembelian::where('user_id', auth()->id())
            ->with('details.obat')
            ->latest()
            ->paginate(10);

        return view('user.beli-obat.riwayat', compact('transaksi'));
    }

    // ================= DETAIL TRANSAKSI =================
    public function detailTransaksi($id)
    {
        $transaksi = TransaksiPembelian::where('user_id', auth()->id())
            ->with(['details.obat', 'verifiedBy'])
            ->findOrFail($id);

        return view('user.beli-obat.detail', compact('transaksi'));
    }
}