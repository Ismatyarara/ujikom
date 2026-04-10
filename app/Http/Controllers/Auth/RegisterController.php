<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OtpController;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/user/profile/create';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'kode_pasien' => User::generateKodePasien(),
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => 'user',
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());
        event(new Registered($user));

        session([
            'otp_email' => $user->email,
            'otp_source' => 'register',
        ]);

        try {
            OtpController::sendOtp($user->email);
        } catch (\Throwable $e) {
            report($e);
            $user->delete();

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'OTP gagal dikirim. Periksa konfigurasi email lalu coba lagi.']);
        }

        return redirect()->route('otp.verify');
    }
}
