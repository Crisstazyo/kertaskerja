@extends('layouts.app')

@section('title', 'Kertas Kerja - Pilih Role')

@section('content')
<div class="min-h-screen py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-20 w-auto mx-auto mb-6">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Pilih Role Anda</h1>
            <p class="text-gray-600">Silakan pilih kategori yang sesuai dengan organisasi Anda</p>
            
            @auth
                <div class="mt-4 inline-flex items-center bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>Login sebagai: <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }})</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline-block ml-4">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-300">
                        Logout
                    </button>
                </form>
            @endauth
        </div>

        <!-- Role Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Government Card -->
            <div class="card-hover bg-white rounded-xl shadow-lg overflow-hidden {{ auth()->check() && auth()->user()->role !== 'government' && auth()->user()->role !== 'admin' ? 'card-disabled' : '' }}">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-center">Government</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Portal untuk instansi pemerintahan</p>
                    @if(auth()->check() && auth()->user()->role === 'government')
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-center mb-4">
                            ✓ Role Aktif
                        </div>
                    @endif
                    <a href="{{ auth()->check() && auth()->user()->role === 'government' ? route('dashboard') : route('login.show', 'government') }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-semibold py-3 rounded-lg transition duration-300">
                        @auth
                            @if(auth()->user()->role === 'government')
                                Dashboard
                            @else
                                Tidak Tersedia
                            @endif
                        @else
                            Login
                        @endauth
                    </a>
                </div>
            </div>

            <!-- Private Card -->
            <div class="card-hover bg-white rounded-xl shadow-lg overflow-hidden {{ auth()->check() && auth()->user()->role !== 'private' && auth()->user()->role !== 'admin' ? 'card-disabled' : '' }}">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 2a2 2 0 00-2 2v11a3 3 0 106 0V4a2 2 0 00-2-2H4zm1 14a1 1 0 100-2 1 1 0 000 2zm5-1.757l4.9-4.9a2 2 0 000-2.828L13.485 5.1a2 2 0 00-2.828 0L10 5.757v8.486zM16 18H9.071l6-6H16a2 2 0 012 2v2a2 2 0 01-2 2z" clip-rule="evenodd"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-center">Private</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Portal untuk perusahaan swasta</p>
                    @if(auth()->check() && auth()->user()->role === 'private')
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-center mb-4">
                            ✓ Role Aktif
                        </div>
                    @endif
                    <a href="{{ auth()->check() && auth()->user()->role === 'private' ? route('dashboard') : route('login.show', 'private') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center font-semibold py-3 rounded-lg transition duration-300">
                        @auth
                            @if(auth()->user()->role === 'private')
                                Dashboard
                            @else
                                Tidak Tersedia
                            @endif
                        @else
                            Login
                        @endauth
                    </a>
                </div>
            </div>

            <!-- SOE Card -->
            <div class="card-hover bg-white rounded-xl shadow-lg overflow-hidden {{ auth()->check() && auth()->user()->role !== 'soe' && auth()->user()->role !== 'admin' ? 'card-disabled' : '' }}">
                <div class="bg-gradient-to-r from-red-500 to-red-600 p-6 text-white">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-2.727 1.17 1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-center">SOE</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Portal untuk BUMN/BUMD</p>
                    @if(auth()->check() && auth()->user()->role === 'soe')
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-center mb-4">
                            ✓ Role Aktif
                        </div>
                    @endif
                    <a href="{{ auth()->check() && auth()->user()->role === 'soe' ? route('dashboard') : route('login.show', 'soe') }}" class="block w-full bg-red-600 hover:bg-red-700 text-white text-center font-semibold py-3 rounded-lg transition duration-300">
                        @auth
                            @if(auth()->user()->role === 'soe')
                                Dashboard
                            @else
                                Tidak Tersedia
                            @endif
                        @else
                            Login
                        @endauth
                    </a>
                </div>
            </div>

            <!-- Admin Card -->
            <div class="card-hover bg-white rounded-xl shadow-lg overflow-hidden {{ auth()->check() && auth()->user()->role !== 'admin' ? 'card-disabled' : '' }}">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-6 text-white">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-center">Admin</h2>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Portal untuk administrator sistem</p>
                    @if(auth()->check() && auth()->user()->role === 'admin')
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-center mb-4">
                            ✓ Role Aktif
                        </div>
                    @endif
                    <a href="{{ auth()->check() && auth()->user()->role === 'admin' ? route('dashboard') : route('login.show', 'admin') }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center font-semibold py-3 rounded-lg transition duration-300">
                        @auth
                            @if(auth()->user()->role === 'admin')
                                Dashboard
                            @else
                                Tidak Tersedia
                            @endif
                        @else
                            Login
                        @endauth
                    </a>
                </div>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" class="inline-block text-gray-600 hover:text-gray-800 font-semibold transition duration-300">
                ← Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
