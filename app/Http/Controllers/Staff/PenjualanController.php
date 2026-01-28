<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluar;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = BarangKeluar::with('obat')
            ->where('kode', 'like', 'PJ-%')
            ->latest()
            ->paginate(10);

        return view('staff.penjualan.index', compact('penjualan'));
    }

    public function create()
    {
        $obat = Obat::where('stok', '>', 0)
            ->where('status', 1)
            ->get();

        return view('staff.penjualan.create', compact('obat'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_obat' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal_keluar' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        DB::transaction(function () use ($data) {

            $obat = Obat::findOrFail($data['id_obat']);

            if ($obat->stok < $data['jumlah']) {
                abort(403, 'Stok obat tidak mencukupi');
            }

            $data['kode'] = 'PJ-' . time();
            $data['deskripsi'] = $data['deskripsi'] ?? 'Penjualan obat';

            BarangKeluar::create($data);

            $obat->decrement('stok', $data['jumlah']);
        });

        return redirect()->route('staff.penjualan.index')
            ->with('success', 'Penjualan berhasil disimpan');
    }

    public function show(BarangKeluar $penjualan)
    {
        return view('staff.penjualan.show', compact('penjualan'));
    }
}
