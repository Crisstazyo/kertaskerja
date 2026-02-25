<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on role
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

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
