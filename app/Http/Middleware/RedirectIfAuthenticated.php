<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Redirect based on user role
                $role = Auth::user()->role;
                
                if ($role === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                if ($role === 'government') {
                    return redirect()->route('government.dashboard');
                }
                
                if ($role === 'gov') {
                    return redirect()->route('gov.dashboard');
                }
                
                if ($role === 'private') {
                    return redirect()->route('private.dashboard');
                }
                
                if ($role === 'soe') {
                    return redirect()->route('soe.dashboard');
                }
                
                if ($role === 'sme') {
                    return redirect()->route('sme.dashboard');
                }
                
                return redirect('/');
            }
        }

        return $next($request);
    }
}
