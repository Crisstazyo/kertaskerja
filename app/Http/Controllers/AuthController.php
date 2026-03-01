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
        $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
            'email' => 'Akun dengan email ini tidak ditemukan.',
            ])->onlyInput('email');
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
         return back()->withErrors([
             'password' => 'Password yang kamu masukkan salah.',
         ])->onlyInput('email');
         }

        Auth::login($user);
        $request->session()->regenerate();

        $role = $user->role;

        if ($role === 'admin')      return redirect()->route('admin.dashboard');
        if ($role === 'government') return redirect()->route('government.dashboard');
        if ($role === 'gov')        return redirect()->route('gov.dashboard');
        if ($role === 'private')    return redirect()->route('private.dashboard');
        if ($role === 'soe')        return redirect()->route('soe.dashboard');
        if ($role === 'sme')        return redirect()->route('sme.dashboard');

        return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
