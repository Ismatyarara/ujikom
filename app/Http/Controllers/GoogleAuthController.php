<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (InvalidStateException $e) {
            return redirect('/login')->with('error', 'Login Google gagal, silakan coba lagi.');
        }

        $user = User::updateOrCreate(
            ['email' => $googleUser->email],
            [
                'name'      => $googleUser->name,
                'google_id' => $googleUser->id,
                'password'  => bcrypt(str()->random(16)),
                'role'      => 'user', // default role untuk Google login
            ]
        );

        Auth::login($user);

        return $this->redirectByRole($user);
    }

    protected function redirectByRole($user)
    {
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'dokter':
                return redirect()->route('dokter.dashboard');

            case 'staff':
                return redirect()->route('staff.dashboard');

            case 'user':
                if (!$user->profile) {
                    return redirect()->route('user.profile.create')
                        ->with('warning', 'Silakan lengkapi profile Anda terlebih dahulu.');
                }
                return redirect()->route('user.dashboard');

            default:
                return redirect('/home');
        }
    }
}