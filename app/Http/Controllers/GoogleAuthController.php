<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google gagal. Coba lagi.');
        }

        $user = User::firstOrNew([
            'email' => $googleUser->getEmail(),
        ]);

        $isNewUser = ! $user->exists;

        $user->forceFill([
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => $user->email_verified_at ?? now(),
            'password' => $user->password ?: bcrypt(Str::random(24)),
            'role' => $user->role ?: 'user',
        ]);

        if ($isNewUser || empty($user->kode_pasien)) {
            $user->kode_pasien = User::generateKodePasien();
        }

        $user->save();

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('user.dashboard');
    }
}
