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
            'id_obat'        => 'required|exists:obat,id',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi'      => 'nullable|string',
        ]);

        // ✅ Validasi stok SEBELUM transaction (bukan di dalam)
        $obat = Obat::findOrFail($data['id_obat']);
        if ($obat->stok < $data['jumlah']) {
            return back()->withErrors([
                'jumlah' => "Stok {$obat->nama_obat} tidak mencukupi. Stok tersedia: {$obat->stok}"
            ])->withInput();
        }

        DB::transaction(function () use ($data) {
            $data['kode'] = 'BK-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
            BarangKeluar::create($data);

            Obat::where('id', $data['id_obat'])
                ->decrement('stok', $data['jumlah']);
        });

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
        $obat = Obat::where('status', 1)->get();
        return view('staff.barang-keluar.edit', compact('barangKeluar', 'obat'));
    }

    public function update(Request $request, BarangKeluar $barangKeluar)
    {
        $data = $request->validate([
            'id_obat'        => 'required|exists:obat,id',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi'      => 'nullable|string',
        ]);

        // ✅ Simulasikan stok setelah rollback lama + potong baru, SEBELUM transaction
        $obatBaru = Obat::findOrFail($data['id_obat']);

        // Stok efektif = stok sekarang + jumlah lama (dikembalikan) - kalau obat sama
        // Kalau obat beda, cukup cek stok obat baru saja
        $stokEfektif = ($barangKeluar->id_obat == $data['id_obat'])
            ? $obatBaru->stok + $barangKeluar->jumlah
            : $obatBaru->stok;

        if ($stokEfektif < $data['jumlah']) {
            return back()->withErrors([
                'jumlah' => "Stok {$obatBaru->nama_obat} tidak mencukupi. Stok tersedia: {$stokEfektif}"
            ])->withInput();
        }

        DB::transaction(function () use ($data, $barangKeluar) {
            // Kembalikan stok dari entry lama
            Obat::where('id', $barangKeluar->id_obat)
                ->increment('stok', $barangKeluar->jumlah);

            // Potong stok baru
            Obat::where('id', $data['id_obat'])
                ->decrement('stok', $data['jumlah']);

            $barangKeluar->update($data);
        });

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil diupdate dan stok diperbarui.');
    }

    public function destroy(BarangKeluar $barangKeluar)
    {
        DB::transaction(function () use ($barangKeluar) {
            // Kembalikan stok saat data dihapus
            Obat::where('id', $barangKeluar->id_obat)
                ->increment('stok', $barangKeluar->jumlah);

            $barangKeluar->delete();
        });

        return redirect()->route('staff.barang-keluar.index')
            ->with('success', 'Barang keluar berhasil dihapus dan stok dikembalikan.');
    }
}