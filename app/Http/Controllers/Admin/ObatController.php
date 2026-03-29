<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::with('user')->paginate(10);
        return view('admin.obat.index', compact('obat'));
    }

    public function pembelian()
    {
        $pembelian = Obat::paginate(10);
        return view('admin.obat.pembelian', compact('pembelian'));
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id); // hapus with('staff')
        return view('admin.obat.show', compact('obat'));
    }
}