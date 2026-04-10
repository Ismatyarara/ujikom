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
        return Socialite::driver('google')
            ->with([
                'prompt' => 'select_account',
            ])
            ->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Login Google gagal. Coba lagi.');
        }

        $email = $googleUser->getEmail();
        $user = User::firstOrNew(['email' => $email]);

        $user->name = $googleUser->getName();
        $user->google_id = $googleUser->getId();
        $user->avatar = $googleUser->getAvatar();

        if (! $user->email_verified_at) {
            $user->email_verified_at = now();
        }

        if (! $user->password) {
            $user->password = bcrypt(Str::random(24));
        }

        if (! $user->role) {
            $user->role = 'user';
        }

        if (! $user->kode_pasien) {
            $user->kode_pasien = User::generateKodePasien();
        }

        $user->save();

        Auth::login($user, true);
        request()->session()->regenerate();

        return redirect()->route('user.dashboard');
    }
}
