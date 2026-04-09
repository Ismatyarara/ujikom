<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('obat')->latest()->paginate(10);

        return view('staff.barang-keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        $obat = Obat::where('stok', '>', 0)
            ->where('status', 1)
            ->orderBy('nama_obat')
            ->get();

        return view('staff.barang-keluar.create', compact('obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($request->id_obat);

        if ($request->jumlah > $obat->stok) {
            return back()->withErrors([
                'jumlah' => 'Stok ' . $obat->nama_obat . ' tidak mencukupi. Stok tersedia: ' . $obat->stok,
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            BarangKeluar::create([
                'kode' => 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
                'id_obat' => $request->id_obat,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'deskripsi' => $request->deskripsi,
            ]);

            $obat->stok = $obat->stok - $request->jumlah;
            $obat->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang keluar gagal ditambahkan.')->withInput();
        }

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan dan stok diperbarui.');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        $barangKeluar->load('obat');

        return view('staff.barang-keluar.show', compact('barangKeluar'));
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $obat = Obat::where('status', 1)
            ->orderBy('nama_obat')
            ->get();

        return view('staff.barang-keluar.edit', compact('barangKeluar', 'obat'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $obatLama = Obat::findOrFail($barangKeluar->id_obat);
        $obatBaru = Obat::findOrFail($request->id_obat);

        if ($barangKeluar->id_obat == $request->id_obat) {
            $stokTersedia = $obatBaru->stok + $barangKeluar->jumlah;
        } else {
            $stokTersedia = $obatBaru->stok;
        }

        if ($request->jumlah > $stokTersedia) {
            return back()->withErrors([
                'jumlah' => 'Stok ' . $obatBaru->nama_obat . ' tidak mencukupi. Stok tersedia: ' . $stokTersedia,
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            $obatLama->stok = $obatLama->stok + $barangKeluar->jumlah;
            $obatLama->save();

            $obatBaru->stok = $obatBaru->stok - $request->jumlah;
            $obatBaru->save();

            $barangKeluar->update([
                'id_obat' => $request->id_obat,
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang keluar gagal diupdate.')->withInput();
        }

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate dan stok diperbarui.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::beginTransaction();

        try {
            $obat = Obat::findOrFail($barangKeluar->id_obat);
            $obat->stok = $obat->stok + $barangKeluar->jumlah;
            $obat->save();

            $barangKeluar->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang keluar gagal dihapus.');
        }

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus dan stok dikembalikan.');
    }
}
