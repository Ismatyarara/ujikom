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
        $obat = Obat::with('user')->paginate(10); 
        return view('admin.obat.index', compact('obat'));
    }

   
    public function pembelian()
{
    $obat = Obat::paginate(10); // Hapus ->with('staff')
    return view('admin.obat.pembelian', compact('obat'));
}

    public function show($id)
    {
        $obat = Obat::with('staff')->findOrFail($id); 
        return view('admin.obat.show', compact('obat'));
    }
}