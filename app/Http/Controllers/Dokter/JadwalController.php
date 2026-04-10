<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\CatatanMedis;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\JadwalObatWaktu;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    // ─────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────
  public function index(Request $request)
{
    $query = Jadwal::with(['user', 'dokter', 'waktuObat'])
        ->orderByDesc('created_at');

    // ✅ filter by pasien kalau ada
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    $jadwals = $query->paginate(10);

    return view('dokter.jadwal.index', compact('jadwals'));
}

    // ─────────────────────────────────────────
    //  CREATE  — WAJIB dari catatan medis
    // ─────────────────────────────────────────
    public function create(Request $request)
    {
        // Tanpa catatan_id → arahkan ke catatan medis
        if (! $request->filled('catatan_id')) {
            return redirect()
                ->route('dokter.catatan.index')
                ->with('info', 'Buat jadwal melalui tombol di tabel catatan medis.');
        }

        $dokter         = Dokter::where('user_id', Auth::id())->firstOrFail();
        $obats          = Obat::orderBy('nama_obat')->get();
        $catatan        = CatatanMedis::with('user')->findOrFail($request->catatan_id);
        $pasienSelected = $catatan->user;

        return view('dokter.jadwal.create', compact(
            'dokter', 'obats', 'catatan', 'pasienSelected'
        ));
    }

    // ─────────────────────────────────────────
    //  STORE  — simpan jadwal + multi-obat + redirect ke atur waktu
    // ─────────────────────────────────────────
    public function store(Request $request)
    {
        $dokter = Dokter::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'user_id'         => 'required|exists:users,id',
            'obats'           => 'required|array|min:1',
            'obats.*'         => 'required|distinct|exists:obat,kode_obat',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        foreach ($request->obats as $kodeObat) {
            $obat = Obat::where('kode_obat', $kodeObat)->first();

            if (! $obat) {
                continue;
            }

            Jadwal::create([
                'user_id'         => $request->user_id,
                'dokter_id'       => $dokter->id,
                'catatan_medis_id'=> $request->catatan_id,
                'nama_obat'       => $obat->nama_obat,
                'deskripsi'       => $request->deskripsi,
                'tanggal_mulai'   => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
            ]);
        }

        return redirect()
            ->route('dokter.jadwal.index')
            ->with('success', 'Jadwal obat berhasil dibuat.');
    }

    // ─────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────
    public function show($id)
    {
        $jadwal = Jadwal::with(['user', 'dokter', 'waktuObat'])->findOrFail($id);

        return view('dokter.jadwal.show', compact('jadwal'));
    }

    // ─────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────
    public function edit($id)
    {
        $jadwal = Jadwal::with(['user', 'dokter', 'waktuObat'])->findOrFail($id);
        $dokter = Dokter::where('user_id', Auth::id())->firstOrFail();
        $obats  = Obat::orderBy('nama_obat')->get();

        return view('dokter.jadwal.edit', compact('jadwal', 'dokter', 'obats'));
    }

    // ─────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $dokter = Dokter::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'obat_kode'       => 'required|exists:obat,kode_obat',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $obat = Obat::where('kode_obat', $request->obat_kode)->firstOrFail();

        $jadwal->update([
            'dokter_id'       => $dokter->id,
            'nama_obat'       => $obat->nama_obat,
            'deskripsi'       => $request->deskripsi,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()
            ->route('dokter.jadwal.edit', $jadwal->id)
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    // ─────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->waktuObat()->delete();
        $jadwal->delete();

        return redirect()
            ->route('dokter.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    //  WAKTU MINUM OBAT — Step 2
    // ─────────────────────────────────────────
    public function createWaktu($jadwalId)
    {
        $jadwal = Jadwal::with(['user', 'dokter'])->findOrFail($jadwalId);

        return view('dokter.jadwal.waktu', compact('jadwal'));
    }

   public function storeWaktu(Request $request, $jadwalId)
{
    $request->validate([
        'waktu'   => 'required|array|min:1',
        'waktu.*' => 'required|date_format:H:i',
    ]);

    $jadwal = Jadwal::findOrFail($jadwalId);

    foreach ($request->waktu as $waktu) {
        $jadwal->waktuObat()->firstOrCreate(['waktu' => $waktu]);
    }

    if ($request->input('from') === 'edit') {
        return redirect()
            ->route('dokter.jadwal.edit', $jadwalId)
            ->with('success', 'Waktu minum obat berhasil ditambahkan!');
    }

    // ✅ Redirect ke show detail jadwal yang baru dibuat
    return redirect()
        ->route('dokter.jadwal.show', $jadwalId)
        ->with('success', 'Jadwal dan waktu minum obat berhasil disimpan!');
}
}
