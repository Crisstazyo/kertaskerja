@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">🛠️</div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Panel Login</h1>
            <p class="text-gray-600">Masukkan kredensial Anda untuk melanjutkan</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <strong>Error!</strong> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="admin@example.com">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="••••••••">
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition duration-300 transform hover:scale-105">
                    Login
                </button>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
