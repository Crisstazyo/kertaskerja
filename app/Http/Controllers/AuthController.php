<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
            'password.min'      => 'Password minimal 6 karakter',
        ]);

        // Check credentials
        if (Auth::attempt(
            ['email' => $request->email, 'password' => $request->password],
            $request->remember_me
        )) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            $user = Auth::user();
            return $this->redirectByRole($user->role);
        }

        return back()
            ->withInput($request->only('email', 'remember_me'))
            ->withErrors(['email' => 'Email atau password salah']);
    }

    /**
     * Handle logout request
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout');
    }

    /**
     * Redirect user by role
     */
    protected function redirectByRole($role)
    {
        $redirects = [
            'admin'       => '/admin',
            'gov'         => '/dashboard/gov',
            'soe'         => '/dashboard/soe',
            'sme'         => '/dashboard/sme',
            'private'     => '/dashboard/private',
            'collection'  => '/dashboard/collection',
            'ctc'         => '/dashboard/ctc',
            'risingStar'  => '/dashboard/rising-star',
        ];

        return redirect($redirects[$role] ?? '/');
    }
}
