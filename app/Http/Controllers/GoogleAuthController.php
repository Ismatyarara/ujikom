<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
 use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    // tambahin ini di atas

public function callback()
{
    try {
        $googleUser = Socialite::driver('google')->user();
    } catch (\Exception $e) {
        return redirect()->route('login')->with('error', 'Login Google gagal. Coba lagi.');
    }

    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name'              => $googleUser->getName(),
            'google_id'         => $googleUser->getId(),
            'avatar'            => $googleUser->getAvatar(),
            'email_verified_at' => now(),
            'password'          => bcrypt(Str::random(24)),
            'role'              => 'user',
        ]
    );

    // kalau user baru → generate kode pasien
    if ($user->wasRecentlyCreated) {
        $user->update([
            'kode_pasien' => User::generateKodePasien(),
        ]);
    }

    // ✅ LANGSUNG LOGIN (tanpa OTP)
    Auth::login($user, true);

    return redirect()->route('user.dashboard');
}
}