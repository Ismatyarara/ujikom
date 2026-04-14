<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\User;
use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanMedisController extends Controller
{
    protected function getDokterAktif(): Dokter
    {
        return Dokter::where('user_id', Auth::id())->firstOrFail();
    }

    protected function getCatatanDokter(int $id): CatatanMedis
    {
        $dokter = $this->getDokterAktif();

        return CatatanMedis::where('dokter_id', $dokter->id)
            ->with(['user', 'dokter'])
            ->findOrFail($id);
    }

  
    public function index(Request $request)
    {
        $dokter = $this->getDokterAktif();

        $query = CatatanMedis::where('dokter_id', $dokter->id)
            ->latest('tanggal_catatan');

        if ($request->filled('kode_pasien')) {
            $query->whereHas('user', fn($q) =>
                $q->where('kode_pasien', $request->kode_pasien)
            );
        }

        $catatan      = $query->paginate(10)->withQueryString();
        $pasienDicari = null;

        if ($request->filled('kode_pasien')) {
            $pasienDicari = User::where('kode_pasien', $request->kode_pasien)
                ->where('role', 'user')
                ->first();
        }

        return view('dokter.catatan.index', compact('catatan', 'pasienDicari'));
    }

    
    public function create(Request $request)
    {
        $selectedUserId = $request->user_id ? (int) $request->user_id : null;
        $selectedPasien = null;

        if ($selectedUserId) {
            $selectedPasien = User::where('role', 'user')->findOrFail($selectedUserId);
        }

        $pasien = $selectedPasien
            ? collect()
            : User::where('role', 'user')->orderBy('name')->get();

        return view('dokter.catatan.create', compact('pasien', 'selectedUserId', 'selectedPasien'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'keluhan'         => 'required|string',
            'diagnosa'        => 'required|string',
            'tanggal_catatan' => 'required|date',
        ]);

        $dokter = $this->getDokterAktif();
        $pasien = User::where('role', 'user')->findOrFail((int) $request->user_id);

        CatatanMedis::create([
            'user_id'         => $pasien->id,
            'dokter_id'       => $dokter->id,
            'keluhan'         => $request->keluhan,
            'diagnosa'        => $request->diagnosa,
            'deskripsi'       => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $catatan = $this->getCatatanDokter((int) $id);

        return view('dokter.catatan.edit', compact('catatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keluhan'         => 'required|string',
            'diagnosa'        => 'required|string',
            'tanggal_catatan' => 'required|date',
        ]);

        $catatan = $this->getCatatanDokter((int) $id);
        $dokter  = $this->getDokterAktif();

        $catatan->update([
            'dokter_id'       => $dokter->id,
            'keluhan'         => $request->keluhan,
            'diagnosa'        => $request->diagnosa,
            'deskripsi'       => $request->deskripsi,
            'tanggal_catatan' => $request->tanggal_catatan,
        ]);

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil diperbarui.');
    }

   
    public function destroy($id)
    {
        $catatan = $this->getCatatanDokter((int) $id);
        $catatan->delete();

        return redirect()->route('dokter.catatan.index')
            ->with('success', 'Catatan berhasil dihapus.');
    }
}
