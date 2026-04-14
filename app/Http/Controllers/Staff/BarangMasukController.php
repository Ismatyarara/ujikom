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
        $barangMasuk = BarangMasuk::with('obat')->latest()->paginate(10);

        return view('staff.barang-masuk.index', compact('barangMasuk'));
    }

    public function create()
    {
        $obat = Obat::where('status', 1)->orderBy('kode_obat')->get();

        return view('staff.barang-masuk.create', compact('obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi' => 'nullable|string',
        ]);

        $obat = Obat::findOrFail($request->id_obat);

        DB::beginTransaction();

        try {
            BarangMasuk::create([
                'kode' => 'BM-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5)),
                'id_obat' => $request->id_obat,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa,
                'deskripsi' => $request->deskripsi,
            ]);

            $obat->stok = $obat->stok + $request->jumlah;
            $obat->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang masuk gagal ditambahkan.')->withInput();
        }

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
        $obat = Obat::where('status', 1)->orderBy('kode_obat')->get();

        return view('staff.barang-masuk.edit', compact('barangMasuk', 'obat'));
    }

    public function update(Request $request, BarangMasuk $barangMasuk)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi' => 'nullable|string',
        ]);

        $obatLama = Obat::findOrFail($barangMasuk->id_obat);
        $obatBaru = Obat::findOrFail($request->id_obat);
        $jumlahLama = (int) $barangMasuk->jumlah;
        $jumlahBaru = (int) $request->jumlah;

        if ($obatLama->stok < $jumlahLama) {
            return back()->withErrors([
                'jumlah' => 'Stok ' . $obatLama->nama_obat . ' sudah terpakai, tidak bisa mengedit data ini.',
            ])->withInput();
        }

        DB::beginTransaction();

        try {
            if ($obatLama->id === $obatBaru->id) {
                $selisihJumlah = $jumlahBaru - $jumlahLama;
                $obatBaru->stok = $obatBaru->stok + $selisihJumlah;
                $obatBaru->save();
            } else {
                $obatLama->stok = $obatLama->stok - $jumlahLama;
                $obatLama->save();

                $obatBaru->stok = $obatBaru->stok + $jumlahBaru;
                $obatBaru->save();
            }

            $barangMasuk->update([
                'id_obat' => $request->id_obat,
                'jumlah' => $jumlahBaru,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa,
                'deskripsi' => $request->deskripsi,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang masuk gagal diupdate.')->withInput();
        }

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil diupdate dan stok diperbarui.');
    }

    public function destroy(BarangMasuk $barangMasuk)
    {
        $obat = Obat::findOrFail($barangMasuk->id_obat);

        if ($obat->stok < $barangMasuk->jumlah) {
            return back()->withErrors([
                'error' => 'Stok ' . $obat->nama_obat . ' sudah terpakai sebagian, tidak bisa menghapus data ini.',
            ]);
        }

        DB::beginTransaction();

        try {
            $obat->stok = $obat->stok - $barangMasuk->jumlah;
            $obat->save();

            $barangMasuk->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Barang masuk gagal dihapus.');
        }

        return redirect()->route('staff.barang-masuk.index')
            ->with('success', 'Barang masuk berhasil dihapus dan stok dikurangi.');
    }
}
