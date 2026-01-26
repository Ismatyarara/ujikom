<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Obat;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = BarangMasuk::with('obat')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('staff.pembelian.index', compact('pembelian'));
    }
    
    public function show($id)
    {
        $pembelian = BarangMasuk::with('obat')->findOrFail($id);
        return view('staff.pembelian.show', compact('pembelian'));
    }
}