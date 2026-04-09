<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use App\Models\TransaksiPembelian;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obat = Obat::with('user')->paginate(10);
        return view('admin.obat.index', compact('obat'));
    }

    public function pembelian(Request $request)
    {
        $search = $request->string('search')->toString();

        $pembelian = TransaksiPembelian::with(['user', 'details.obat'])
            ->when($search, function ($query, $search) {
                $query->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.obat.pembelian', compact('pembelian'));
    }

    public function showPembelian(TransaksiPembelian $pembelian)
    {
        $pembelian->load(['user', 'details.obat']);

        return view('admin.obat.pembelian-show', compact('pembelian'));
    }

    public function show($id)
    {
        $obat = Obat::findOrFail($id); // hapus with('staff')
        return view('admin.obat.show', compact('obat'));
    }
}
