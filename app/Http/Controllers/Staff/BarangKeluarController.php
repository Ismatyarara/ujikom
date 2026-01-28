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
        $barangKeluar = BarangKeluar::with('obat')
            ->latest()
            ->paginate(10);

        return view('staff.barang-keluar.index', compact('barangKeluar'));
    }

    public function create()
    {
        $obat = Obat::where('stok', '>', 0)
            ->where('status', 1)
            ->get();

        return view('staff.barang-keluar.create', compact('obat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_obat' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        DB::transaction(function () use ($data) {

            $obat = Obat::findOrFail($data['id_obat']);

            if ($obat->stok < $data['jumlah']) {
                abort(403, 'Stok obat tidak mencukupi');
            }

            $data['kode'] = 'BK-' . time();
            BarangKeluar::create($data);

            $obat->decrement('stok', $data['jumlah']);
        });

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil ditambahkan');
    }

    public function show(BarangKeluar $barangKeluar)
    {
        return view('staff.barang-keluar.show', compact('barangKeluar'));
    }

    public function edit(BarangKeluar $barangKeluar)
    {
        $obat = Obat::where('status', 1)->get();
        return view('staff.barang-keluar.edit', compact('barangKeluar', 'obat'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $data = $request->validate([
            'id_obat' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        DB::transaction(function () use ($data, $barangKeluar) {

            // balikin stok lama
            Obat::where('id', $barangKeluar->id_obat)
                ->increment('stok', $barangKeluar->jumlah);

            $obatBaru = Obat::findOrFail($data['id_obat']);

            if ($obatBaru->stok < $data['jumlah']) {
                abort(403, 'Stok obat tidak mencukupi');
            }

            // kurangi stok baru
            $obatBaru->decrement('stok', $data['jumlah']);

            $barangKeluar->update($data);
        });

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {

            Obat::where('id', $barangKeluar->id_obat)
                ->increment('stok', $barangKeluar->jumlah);

            $barangKeluar->delete();
        });

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus');
    }
}
