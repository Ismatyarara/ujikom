<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class DataObatController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $obat = Obat::where('status', 1)
            ->orderBy('nama_obat')
            ->get();

        return view('dokter.data-obat.index', compact('obat'));
    }

    // ================= SHOW =================
    public function show($id)
    {
        $obat = Obat::findOrFail($id);

        return view('dokter.data-obat.show', compact('obat'));
    }
}