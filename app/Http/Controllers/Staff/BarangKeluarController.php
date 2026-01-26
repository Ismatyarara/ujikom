<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index()
    {
        $barangKeluar = BarangKeluar::with('obat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('staff.barang-keluar.index', compact('barangKeluar'));
    }
    
    public function create()
    {
        $obat = Obat::where('stok', '>', 0)->get();
        return view('staff.barang-keluar.create', compact('obat'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_obat' => 'required|exists:obat,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable|string'
        ]);
        
        DB::beginTransaction();
        try {
            $obat = Obat::findOrFail($request->id_obat);
            
            // Cek stok
            if ($obat->stok < $request->jumlah) {
                return back()->with('error', 'Stok obat tidak mencukupi. Stok tersedia: ' . $obat->stok);
            }
            
            // Buat transaksi barang keluar
            BarangKeluar::create([
                'id_obat' => $request->id_obat,
                'kode' => 'BK-' . date('Ymd') . '-' . str_pad(BarangKeluar::count() + 1, 4, '0', STR_PAD_LEFT),
                'jumlah' => $request->jumlah,
                'tanggal_keluar' => $request->tanggal_keluar,
                'deskripsi' => $request->deskripsi
            ]);
            
            // Kurangi stok
            $obat->decrement('stok', $request->jumlah);
            
            DB::commit();
            return redirect()->route('staff.barang-keluar.index')->with('success', 'Barang keluar berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $barangKeluar = BarangKeluar::with('obat')->findOrFail($id);
        return view('staff.barang-keluar.show', compact('barangKeluar'));
    }
    
    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $obat = Obat::all();
        return view('staff.barang-keluar.edit', compact('barangKeluar', 'obat'));
    }
    
   public function update(Request $request, BarangKeluar $barangKeluar)
{
    $request->validate([
        'id_obat' => 'required|exists:obat,id',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required|date',
        'deskripsi' => 'nullable|string'
    ]);

    DB::transaction(function () use ($request, $barangKeluar) {
        // 1. Kembalikan stok obat lama
        Obat::findOrFail($barangKeluar->id_obat)->increment('stok', $barangKeluar->jumlah);

        // 2. Kurangi stok obat baru
        $obatBaru = Obat::findOrFail($request->id_obat);
        if ($obatBaru->stok < $request->jumlah) {
            throw new \Exception('Stok obat tidak mencukupi.');
        }
        $obatBaru->decrement('stok', $request->jumlah);

        // 3. Update data barang keluar
        $barangKeluar->update($request->only('id_obat', 'jumlah', 'tanggal_keluar', 'deskripsi'));
    });

    return redirect()->route('staff.barang-keluar.index')->with('success', 'Barang keluar berhasil diupdate');
}

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $barangKeluar = BarangKeluar::findOrFail($id);
            
            // Kembalikan stok
            $obat = Obat::findOrFail($barangKeluar->id_obat);
            $obat->increment('stok', $barangKeluar->jumlah);
            
            $barangKeluar->delete();
            
            DB::commit();
            return redirect()->route('staff.barang-keluar.index')->with('success', 'Barang keluar berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}