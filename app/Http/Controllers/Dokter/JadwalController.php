<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\JadwalObatWaktu;
use App\Models\Obat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Tampilkan daftar semua jadwal obat.
     */
    public function index()
    {
        $jadwals = Jadwal::with(['user', 'dokter', 'waktuObat'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dokter.jadwal.index', compact('jadwals'));
    }

    /**
     * Form tambah jadwal — Langkah 1.
     */
    public function create()
    {
        $dokters = Dokter::orderBy('nama')->get();
        $pasien  = User::where('role', 'user')->orderBy('name')->get();
        $obats   = Obat::orderBy('nama_obat')->get();

        return view('dokter.jadwal.create', compact('dokters', 'pasien', 'obats'));
    }

    /**
     * Simpan jadwal baru, lalu arahkan ke halaman atur waktu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'dokter_id'       => 'required|exists:dokter,id',
            'nama_obat'       => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $jadwal = Jadwal::create($validated);

        return redirect()
            ->route('dokter.jadwal.waktu.create', $jadwal->id)
            ->with('success', 'Jadwal berhasil dibuat! Silakan atur waktu minum obat.');
    }

    /**
     * Form edit jadwal — tampilkan data lama + daftar waktu yang sudah ada.
     */
    public function edit($id)
    {
        $jadwal  = Jadwal::with(['user', 'dokter', 'waktuObat'])->findOrFail($id);
        $dokters = Dokter::orderBy('nama')->get();
        $pasien  = User::where('role', 'user')->orderBy('name')->get();
        $obats   = Obat::orderBy('nama_obat')->get();

        return view('dokter.jadwal.edit', compact('jadwal', 'dokters', 'pasien', 'obats'));
    }

    /**
     * Update data jadwal.
     */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $validated = $request->validate([
            'user_id'         => 'required|exists:users,id',
            'dokter_id'       => 'required|exists:dokter,id',
            'nama_obat'       => 'required|string|max:255',
            'deskripsi'       => 'nullable|string',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $jadwal->update($validated);

        return redirect()
            ->route('dokter.jadwal.edit', $jadwal->id)
            ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Hapus jadwal beserta semua waktu terkait.
     */
    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->waktuObat()->delete(); // hapus relasi dulu
        $jadwal->delete();

        return redirect()
            ->route('dokter.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }

    // ─────────────────────────────────────────
    //  WAKTU MINUM OBAT — Langkah 2 (Create flow)
    // ─────────────────────────────────────────

    /**
     * Halaman atur waktu setelah jadwal baru dibuat.
     */
    public function createWaktu($jadwalId)
    {
        $jadwal = Jadwal::with(['user', 'dokter'])->findOrFail($jadwalId);

        return view('dokter.jadwal.waktu', compact('jadwal'));
    }

    /**
     * Simpan waktu-waktu minum obat.
     * Dipanggil dari halaman create-waktu (step 2) maupun halaman edit.
     * TIDAK menghapus waktu lama — penghapusan per-item ditangani JadwalObatController.
     */
    public function storeWaktu(Request $request, $jadwalId)
    {
        $request->validate([
            'waktu'   => 'required|array|min:1',
            'waktu.*' => 'required|date_format:H:i',
        ]);

        $jadwal = Jadwal::findOrFail($jadwalId);

        foreach ($request->waktu as $waktu) {
            // Hindari duplikat waktu yang sama di jadwal yang sama
            $jadwal->waktuObat()->firstOrCreate(['waktu' => $waktu]);
        }

        // Jika dipanggil dari halaman edit, kembali ke edit
        $from = $request->input('from');
        if ($from === 'edit') {
            return redirect()
                ->route('dokter.jadwal.edit', $jadwalId)
                ->with('success', 'Waktu minum obat berhasil ditambahkan!');
        }

        return redirect()
            ->route('dokter.jadwal.index')
            ->with('success', 'Waktu minum obat berhasil disimpan!');
    }
}