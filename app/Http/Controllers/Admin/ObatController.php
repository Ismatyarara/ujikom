<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    // Tampilkan data obat
    public function index()
    {
        $obat = Obat::paginate(10);
        return view('admin.obat.index', compact('obat'));
    }

    // Tampilkan data pembelian obat (read-only)
    public function pembelian()
    {
        // Bisa pakai stok / harga sebagai representasi histori pembelian
        $obat = Obat::paginate(10);
        return view('admin.obat.pembelian', compact('obat'));
    }

    public function show($id)
{
    $obat = Obat::findOrFail($id); // Ambil data obat berdasarkan id
    return view('admin.obat.show', compact('obat'));
}
}
