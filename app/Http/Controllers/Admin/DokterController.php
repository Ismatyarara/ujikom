<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\User;
use App\Models\Spesialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with(['pengguna', 'spesialisasi'])->paginate(10);
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('admin.dokter.create', [
            'spesialisasi' => Spesialisasi::all()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'nama' => 'required',
            'spesialisasi_id' => 'required|exists:spesialisasi,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jadwal_praktik_hari' => 'required',
            'jadwal_praktik_waktu' => 'required',
            'tempat_praktik' => 'required',
            'pengalaman' => 'nullable',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama.required' => 'Nama dokter wajib diisi.',
            'spesialisasi_id.required' => 'Spesialisasi wajib dipilih.',
            'tempat_praktik.required' => 'Tempat praktik wajib diisi.',
        ]);

        $user = User::create([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        Dokter::create([
            'user_id' => $user->id,
            'nama' => $data['nama'],
            'spesialisasi_id' => $data['spesialisasi_id'],
            'foto' => $request->hasFile('foto')
                ? $request->file('foto')->store('dokter', 'public')
                : null,
            'jadwal_praktik_hari' => $data['jadwal_praktik_hari'],
            'jadwal_praktik_waktu' => $data['jadwal_praktik_waktu'],
            'tempat_praktik' => $data['tempat_praktik'],
            'pengalaman' => $data['pengalaman'] ?? null,
        ]);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function show(Dokter $dokter)
    {
        $dokter->load(['pengguna', 'spesialisasi']);
        return view('admin.dokter.show', compact('dokter'));
    }

    public function edit(Dokter $dokter)
    {
        $dokter->load('pengguna');

        return view('admin.dokter.edit', [
            'dokter' => $dokter,
            'spesialisasi' => Spesialisasi::all()
        ]);
    }

    public function update(Request $request, Dokter $dokter)
    {
        $data = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($dokter->user_id),
            ],
            'password' => 'nullable|min:8',
            'nama' => 'required',
            'spesialisasi_id' => 'required|exists:spesialisasi,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jadwal_praktik_hari' => 'required',
            'jadwal_praktik_waktu' => 'required',
            'tempat_praktik' => 'required',
            'pengalaman' => 'nullable',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama.required' => 'Nama dokter wajib diisi.',
            'spesialisasi_id.required' => 'Spesialisasi wajib dipilih.',
        ]);

        $dokter->pengguna->update([
            'name' => $data['nama'],
            'email' => $data['email'],
            'password' => $request->filled('password')
                ? Hash::make($data['password'])
                : $dokter->pengguna->password,
        ]);

        if ($request->hasFile('foto')) {
            if ($dokter->foto) {
                Storage::disk('public')->delete($dokter->foto);
            }
            $data['foto'] = $request->file('foto')->store('dokter', 'public');
        }

        unset($data['email'], $data['password']);

        $dokter->update($data);

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Dokter $dokter)
    {
        if ($dokter->foto) {
            Storage::disk('public')->delete($dokter->foto);
        }

        $dokter->pengguna->delete();

        return redirect()
            ->route('admin.dokter.index')
            ->with('success', 'Dokter berhasil dihapus.');
    }
}
