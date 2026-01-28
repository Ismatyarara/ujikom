<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangMasuk;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = BarangMasuk::with('obat')
            ->latest()
            ->paginate(10);

        return view('staff.pembelian.index', compact('pembelian'));
    }

    public function show(BarangMasuk $pembelian)
    {
        return view('staff.pembelian.show', compact('pembelian'));
    }
}
