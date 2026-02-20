@extends('layouts.app')

@section('title', 'Login - ' . ucfirst($role))

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-20 w-auto mx-auto mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Login {{ ucfirst($role) }}</h1>
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
                <input type="hidden" name="role" value="{{ $role }}">
                
                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Masukkan email Anda">
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Masukkan password Anda">
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
            <a href="{{ route('roles') }}" class="text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                ← Kembali ke Pilihan Role
            </a>
        </div>
    </div>
</div>
@endsection
