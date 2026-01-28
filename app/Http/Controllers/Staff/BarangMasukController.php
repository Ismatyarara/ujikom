<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('obat')
            ->latest()
            ->paginate(10);

        return view('staff.barang-masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $obat = Obat::where('status', 1)->get();
        return view('staff.barang-masuk.create', compact('obat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_obat' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        DB::transaction(function () use ($data) {

            $data['kode'] = 'BM-' . time();
            BarangMasuk::create($data);

            // tambah stok
            Obat::where('id', $data['id_obat'])
                ->increment('stok', $data['jumlah']);
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        return view('staff.barang-masuk.show', compact('barangMasuk'));
    }

    public function edit(BarangMasuk $barangMasuk)
    {
        $obat = Obat::where('status', 1)->get();
        return view('staff.barang-masuk.edit', compact('barangMasuk', 'obat'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $data = $request->validate([
            'id_obat' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        DB::transaction(function () use ($data, $barangMasuk) {

            // balikin stok lama
            Obat::where('id', $barangMasuk->id_obat)
                ->decrement('stok', $barangMasuk->jumlah);

            // tambah stok baru
            Obat::where('id', $data['id_obat'])
                ->increment('stok', $data['jumlah']);

            $barangMasuk->update($data);
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        DB::transaction(function () use ($barangMasuk) {

            Obat::where('id', $barangMasuk->id_obat)
                ->decrement('stok', $barangMasuk->jumlah);

            $barangMasuk->delete();
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus');
    }
}
