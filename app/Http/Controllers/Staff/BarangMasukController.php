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
            'id_obat'             => 'required|exists:obat,id',
            'jumlah'              => 'required|integer|min:1',
            'tanggal_masuk'       => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi'           => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {
            $data['kode'] = 'BM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            BarangMasuk::create($data);

            // Tambah stok obat
            Obat::where('id', $data['id_obat'])
                ->increment('stok', $data['jumlah']);
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil ditambahkan dan stok diperbarui.');
    }

    public function show(BarangMasuk $barangMasuk)
    {
        $barangMasuk->load('obat');
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
            'id_obat'             => 'required|exists:obat,id',
            'jumlah'              => 'required|integer|min:1',
            'tanggal_masuk'       => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi'           => 'nullable|string',
        ]);

        // Validasi: kalau obat lama diubah, pastikan stok lama cukup untuk dikurangi
        $obatLama = Obat::findOrFail($barangMasuk->id_obat);
        if ($obatLama->stok < $barangMasuk->jumlah) {
            return back()->withErrors([
                'jumlah' => "Stok {$obatLama->nama_obat} sudah terpakai, tidak bisa mengedit data ini."
            ])->withInput();
        }

        DB::transaction(function () use ($data, $barangMasuk) {
            // Kurangi stok obat lama (batalkan entry lama)
            Obat::where('id', $barangMasuk->id_obat)
                ->decrement('stok', $barangMasuk->jumlah);

            // Tambah stok obat baru (bisa obat sama atau berbeda)
            Obat::where('id', $data['id_obat'])
                ->increment('stok', $data['jumlah']);

            $barangMasuk->update($data);
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate dan stok diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        // Validasi stok cukup sebelum dihapus
        $obat = Obat::findOrFail($barangMasuk->id_obat);
        if ($obat->stok < $barangMasuk->jumlah) {
            return back()->withErrors([
                'error' => "Stok {$obat->nama_obat} sudah terpakai sebagian, tidak bisa menghapus data ini."
            ]);
        }

        DB::transaction(function () use ($barangMasuk) {
            Obat::where('id', $barangMasuk->id_obat)
                ->decrement('stok', $barangMasuk->jumlah);

            $barangMasuk->delete();
        });

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus dan stok dikurangi.');
    }
}