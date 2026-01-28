<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    
    /**
     * Redirect user based on role after login
     *
     * @param Request $request
     * @param mixed $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect berdasarkan role
        switch($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                
            case 'dokter':
                return redirect()->route('dokter.dashboard');
                
            case 'staff':
                return redirect()->route('staff.dashboard');
                
            case 'user':
                // Cek apakah user sudah punya profile
                if (!$user->profile) {
                    return redirect()->route('user.profile.create')
                        ->with('warning', 'Silakan lengkapi profile Anda terlebih dahulu untuk mengakses dashboard.');
                }
                // Jika sudah punya profile, ke dashboard
                return redirect()->route('user.dashboard');
                
            default:
                return redirect('/home');
        }
    }
}