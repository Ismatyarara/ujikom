<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with(['pengguna', 'spesialisasi'])->paginate(10); 
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $spesialisasi = Spesialisasi::all();
        return view('admin.dokter.create', compact('spesialisasi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nama' => 'required|string|max:255',
            'id_spesialisasi' => 'required|exists:spesialisasi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jadwal_praktik_hari' => 'required|string',
            'jadwal_praktik_waktu' => 'required|string',
            'tempat_praktik' => 'required|string',
        ]);

        // Create user - PERBAIKAN: gunakan 'nama' bukan 'name'
        $user = User::create([
            'name' => $validated['nama'], // FIX: gunakan 'nama' dari validated
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        // Create dokter
        Dokter::create([
            'id_user' => $user->id,
            'nama' => $validated['nama'],
            'id_spesialisasi' => $validated['id_spesialisasi'],
            'foto' => $request->hasFile('foto') ? $request->file('foto')->store('dokter', 'public') : null,
            'jadwal_praktik_hari' => $validated['jadwal_praktik_hari'],
            'jadwal_praktik_waktu' => $validated['jadwal_praktik_waktu'],
            'tempat_praktik' => $validated['tempat_praktik'],
        ]);

        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil ditambahkan');
    }

    public function show(Dokter $dokter)
    {
        $dokter->load(['pengguna', 'spesialisasi']);
        return view('admin.dokter.show', compact('dokter'));
    }

    public function edit(Dokter $dokter)
    {
        $spesialisasi = Spesialisasi::all();
        $dokter->load('pengguna');
        return view('admin.dokter.edit', compact('dokter', 'spesialisasi'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $dokter->id_user,
            'password' => 'nullable|min:8',
            'nama' => 'required|string|max:255',
            'id_spesialisasi' => 'required|exists:spesialisasi,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jadwal_praktik_hari' => 'required|string',
            'jadwal_praktik_waktu' => 'required|string',
            'tempat_praktik' => 'required|string',
        ]);

        // Update user - PERBAIKAN: gunakan 'nama' bukan 'name'
        $dokter->pengguna->update([
            'name' => $validated['nama'], // FIX: gunakan 'nama' dari validated
            'email' => $validated['email'],
            'password' => $request->filled('password') ? Hash::make($validated['password']) : $dokter->pengguna->password,
        ]);

        // Prepare dokter data
        $dokterData = [
            'nama' => $validated['nama'],
            'id_spesialisasi' => $validated['id_spesialisasi'],
            'jadwal_praktik_hari' => $validated['jadwal_praktik_hari'],
            'jadwal_praktik_waktu' => $validated['jadwal_praktik_waktu'],
            'tempat_praktik' => $validated['tempat_praktik'],
        ];

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $dokterData['foto'] = $request->file('foto')->store('dokter', 'public');
        }

        $dokter->update($dokterData);

        return redirect()->route('admin.dokter.index')->with('success', 'Data dokter berhasil diupdate');
    }

    public function destroy(Dokter $dokter)
    {
        // Delete foto if exists
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }
        
        // Delete user (cascade will delete dokter)
        $dokter->pengguna->delete();
        
        return redirect()->route('admin.dokter.index')->with('success', 'Dokter berhasil dihapus');
    }
}