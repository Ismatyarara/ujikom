<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Data penjualan otomatis dari transaksi user (kode PJ-).
     * Staff hanya bisa edit & hapus untuk koreksi.
     */
    public function index()
    {
        $penjualan = BarangKeluar::with('obat')
            ->where('kode', 'like', 'PJ-%')
            ->latest()
            ->paginate(10);

        return view('staff.penjualan.index', compact('penjualan'));
    }

    public function show(BarangKeluar $penjualan)
    {
        abort_unless(str_starts_with($penjualan->kode, 'PJ-'), 404);

        $penjualan->load('obat');
        return view('staff.penjualan.show', compact('penjualan'));
    }

    public function edit(BarangKeluar $penjualan)
    {
        abort_unless(str_starts_with($penjualan->kode, 'PJ-'), 404);

        $obat = Obat::where('status', 1)->get();
        return view('staff.penjualan.edit', compact('penjualan', 'obat'));
    }

    public function update(Request $request, BarangKeluar $penjualan)
    {
        abort_unless(str_starts_with($penjualan->kode, 'PJ-'), 404);

        $data = $request->validate([
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi'      => 'nullable|string',
        ]);

        // ✅ Hitung stok efektif setelah rollback jumlah lama, SEBELUM transaction
        $obat = Obat::findOrFail($penjualan->id_obat);
        $stokEfektif = $obat->stok + $penjualan->jumlah; // stok kalau entry lama dibatalkan

        if ($stokEfektif < $data['jumlah']) {
            return back()->withErrors([
                'jumlah' => "Stok {$obat->nama_obat} tidak mencukupi. Stok tersedia: {$stokEfektif}"
            ])->withInput();
        }

        DB::transaction(function () use ($data, $penjualan) {
            // Kembalikan stok lama
            Obat::where('id', $penjualan->id_obat)
                ->increment('stok', $penjualan->jumlah);

            // Potong stok dengan jumlah baru
            Obat::where('id', $penjualan->id_obat)
                ->decrement('stok', $data['jumlah']);

            $penjualan->update($data);
        });

        return redirect()->route('staff.penjualan.index')
            ->with('success', 'Data penjualan berhasil diperbarui dan stok dikoreksi.');
    }

    public function destroy(BarangKeluar $penjualan)
    {
        abort_unless(str_starts_with($penjualan->kode, 'PJ-'), 404);

        DB::transaction(function () use ($penjualan) {
            // Kembalikan stok saat penjualan dihapus/dibatalkan
            Obat::where('id', $penjualan->id_obat)
                ->increment('stok', $penjualan->jumlah);

            $penjualan->delete();
        });

        return redirect()->route('staff.penjualan.index')
            ->with('success', 'Data penjualan berhasil dihapus dan stok dikembalikan.');
    }
}