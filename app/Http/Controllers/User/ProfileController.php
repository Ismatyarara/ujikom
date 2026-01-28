<?php


namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // User: Tampilkan profile ATAU redirect ke create
    public function show()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()->route('user.profile.create');
        }

        return view('user.profile.show', compact('profile'));
    }

    // User: Form create profile
    public function create()
    {
        if (Auth::user()->profile) {
            return redirect()->route('user.profile.show');
        }
        
        return view('user.profile.create');
    }

    // User: Simpan profile baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_panjang'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('profile', 'public');
        }

        UserProfile::create($validated);

        return redirect()->route('user.profile.show')
            ->with('success', 'Profile berhasil disimpan!');
    }

    // User: Form edit profile
    public function edit()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()->route('user.profile.create');
        }

        return view('user.profile.edit', compact('profile'));
    }

    // User: Update profile
    public function update(Request $request)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()->route('user.profile.create');
        }

        $validated = $request->validate([
            'nama_panjang'   => 'required|string|max:255',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O,-',
            'no_hp'          => 'required|string|max:20',
            'alamat'         => 'required|string',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }
            $validated['foto'] = $request->file('foto')->store('profile', 'public');
        }

        $profile->update($validated);

        return redirect()->route('user.profile.show')
            ->with('success', 'Profile berhasil diperbarui.');
    }

    // User: Delete profile
    public function destroy()
    {
        $profile = Auth::user()->profile;

        if ($profile) {
            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }
            $profile->delete();
        }

        return redirect()->route('user.profile.create')
            ->with('success', 'Profile berhasil dihapus.');
    }
}