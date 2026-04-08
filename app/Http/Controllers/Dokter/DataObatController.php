<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class DataObatController extends Controller
{
    // ================= INDEX =================
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));

        $obat = Obat::where('status', 1)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery->where('nama_obat', 'like', "%{$search}%")
                        ->orWhere('kode_obat', 'like', "%{$search}%")
                        ->orWhere('aturan_pakai', 'like', "%{$search}%")
                        ->orWhere('efek_samping', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_obat')
            ->paginate(12)
            ->withQueryString();

        return view('dokter.data-obat.index', compact('obat', 'search'));
    }

    // ================= SHOW =================
    public function show($id)
    {
        $obat = Obat::findOrFail($id);

        return view('dokter.data-obat.show', compact('obat'));
    }
}
