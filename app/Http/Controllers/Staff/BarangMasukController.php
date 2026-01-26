<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index()
    {
        $barangMasuk = BarangMasuk::with('obat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('staff.barang-masuk.index', compact('barangMasuk'));
    }
    
    public function create()
    {
        $obat = Obat::all();
        return view('staff.barang-masuk.create', compact('obat'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        try {
            // Buat transaksi barang masuk
            BarangMasuk::create([
                'id_obat' => $request->id_obat,
                'kode' => 'BM-' . date('Ymd') . '-' . str_pad(BarangMasuk::count() + 1, 4, '0', STR_PAD_LEFT),
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa,
                'deskripsi' => $request->deskripsi
            ]);
            
            // Tambah stok
            $obat = Obat::findOrFail($request->id_obat);
            $obat->increment('stok', $request->jumlah);
            
            DB::commit();
            return redirect()->route('staff.barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $barangMasuk = BarangMasuk::with('obat')->findOrFail($id);
        return view('staff.barang-masuk.show', compact('barangMasuk'));
    }
    
    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $obat = Obat::all();
        return view('staff.barang-masuk.edit', compact('barangMasuk', 'obat'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluwarsa' => 'required|date|after:tanggal_masuk',
            'deskripsi' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        try {
            $barangMasuk = BarangMasuk::findOrFail($id);
            $oldJumlah = $barangMasuk->jumlah;
            $oldObatId = $barangMasuk->id_obat;
            
            // Update barang masuk
            $barangMasuk->update([
                'id_obat' => $request->id_obat,
                'jumlah' => $request->jumlah,
                'tanggal_masuk' => $request->tanggal_masuk,
                'tanggal_kadaluwarsa' => $request->tanggal_kadaluwarsa,
                'deskripsi' => $request->deskripsi
            ]);
            
            // Update stok obat lama
            if ($oldObatId != $request->id_obat) {
                $obatLama = Obat::findOrFail($oldObatId);
                $obatLama->decrement('stok', $oldJumlah);
                
                $obatBaru = Obat::findOrFail($request->id_obat);
                $obatBaru->increment('stok', $request->jumlah);
            } else {
                $obat = Obat::findOrFail($request->id_obat);
                $selisih = $request->jumlah - $oldJumlah;
                if ($selisih > 0) {
                    $obat->increment('stok', abs($selisih));
                } else if ($selisih < 0) {
                    $obat->decrement('stok', abs($selisih));
                }
            }
            
            DB::commit();
            return redirect()->route('staff.barang-masuk.index')->with('success', 'Barang masuk berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $barangMasuk = BarangMasuk::findOrFail($id);
            
            // Kurangi stok
            $obat = Obat::findOrFail($barangMasuk->id_obat);
            $obat->decrement('stok', $barangMasuk->jumlah);
            
            $barangMasuk->delete();
            
            DB::commit();
            return redirect()->route('staff.barang-masuk.index')->with('success', 'Barang masuk berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}