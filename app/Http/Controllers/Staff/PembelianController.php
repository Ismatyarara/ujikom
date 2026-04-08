<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPembelian;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = TransaksiPembelian::with(['user', 'details.obat'])
            ->latest()
            ->paginate(10);

        return view('staff.pembelian.index', compact('pembelian'));
    }

    public function show(TransaksiPembelian $pembelian)
    {
        $pembelian->load(['user', 'details.obat']);

        return view('staff.pembelian.show', compact('pembelian'));
    }
}
