<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user tidak login, redirect ke login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Check if user role matches allowed roles
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // Unauthorized
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
