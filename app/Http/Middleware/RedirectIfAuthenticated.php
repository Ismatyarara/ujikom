<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $role = Auth::user()->role;
                
                switch($role) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'dokter':
                        return redirect()->route('dokter.dashboard');
                    case 'staff':
                        return redirect()->route('staff.dashboard');
                    case 'user':
                        return redirect()->route('user.dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}