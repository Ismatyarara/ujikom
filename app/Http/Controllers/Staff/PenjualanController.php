<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = BarangKeluar::with('obat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('staff.penjualan.index', compact('penjualan'));
    }
    
    public function create()
    {
        $obat = Obat::where('stok', '>', 0)->get();
        return view('staff.penjualan.create', compact('obat'));
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
            
            // Buat transaksi penjualan
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
            return redirect()->route('staff.penjualan.index')->with('success', 'Penjualan berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $penjualan = BarangKeluar::with('obat')->findOrFail($id);
        return view('staff.penjualan.show', compact('penjualan'));
    }
}