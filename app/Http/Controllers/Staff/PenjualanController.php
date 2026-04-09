<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
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
        if (!str_starts_with($penjualan->kode, 'PJ-')) {
            abort(404);
        }

        $penjualan->load('obat');

        return view('staff.penjualan.show', compact('penjualan'));
    }

    public function edit(BarangKeluar $penjualan)
    {
        if (!str_starts_with($penjualan->kode, 'PJ-')) {
            abort(404);
        }

        $obat = Obat::where('status', 1)->orderBy('nama_obat')->get();

        return view('staff.penjualan.edit', compact('penjualan', 'obat'));
    }

    public function update(Request $request, BarangKeluar $penjualan)
    {
        if (!str_starts_with($penjualan->kode, 'PJ-')) {
            abort(404);
        }

        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($penjualan->id_obat);
        $stokTersedia = $obat->stok + $penjualan->jumlah;

        if ($request->jumlah > $stokTersedia) {
            return back()->withErrors([
                'jumlah' => 'Stok ' . $obat->nama_obat . ' tidak mencukupi. Stok tersedia: ' . $stokTersedia,
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            $obat->stok = $obat->stok + $penjualan->jumlah;
            $obat->save();

            $obat->stok = $obat->stok - $request->jumlah;
            $obat->save();

            $penjualan->update([
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Data penjualan gagal diupdate.')->withInput();
        }

        return redirect()->route('staff.penjualan.index')
            ->with('success', 'Data penjualan berhasil diperbarui dan stok dikoreksi.');
    }

    public function destroy(BarangKeluar $penjualan)
    {
        if (!str_starts_with($penjualan->kode, 'PJ-')) {
            abort(404);
        }

        DB::beginTransaction();

        try {
            $obat = Obat::findOrFail($penjualan->id_obat);
            $obat->stok = $obat->stok + $penjualan->jumlah;
            $obat->save();

            $penjualan->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Data penjualan gagal dihapus.');
        }

        return redirect()->route('staff.penjualan.index')
            ->with('success', 'Data penjualan berhasil dihapus dan stok dikembalikan.');
    }
}
