@extends('layouts.app')

@section('title', 'Kertas Kerja Management System')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-md border-b-4 border-red-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-12 w-auto">
                    <div class="border-l-2 border-gray-300 h-12"></div>
                    <div>
                        <div class="text-xl font-bold text-gray-800">Kertas Kerja</div>
                        <div class="text-xs text-gray-500">Management System</div>
                    </div>
                </div>
                <div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-6 py-2 text-gray-600 hover:text-gray-800 font-medium transition duration-300">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.show') }}" 
                           class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Main Hero -->
        <div class="text-center mb-16">
            <div class="inline-block mb-6">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-2 rounded-full text-sm font-semibold shadow-lg">
                    ✨ Platform Manajemen Worksheet Profesional
                </div>
            </div>
            <h1 class="text-6xl font-bold text-gray-900 mb-6">
                Sistem Manajemen<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-800">
                    Kertas Kerja Terintegrasi
                </span>
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                Platform digital untuk pengelolaan worksheet PSAK dan Scalling dengan fitur lengkap, 
                interface modern, dan sistem terstruktur untuk meningkatkan efisiensi kerja Anda
            </p>
            <div class="flex justify-center gap-4">
                <a href="{{ route('login.show') }}" 
                   class="px-10 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-lg transition duration-300 transform hover:scale-105 shadow-xl flex items-center space-x-2">
                    <span>Mulai Sekarang</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
                <a href="#features" 
                   class="px-10 py-4 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-lg transition duration-300 border-2 border-gray-300 hover:border-red-600 shadow-xl">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>

        <!-- Features Grid -->
        <div id="features" class="grid md:grid-cols-3 gap-8 mb-16">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-green-500">
                <div class="bg-gradient-to-br from-green-100 to-green-50 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Government Panel</h3>
                <p class="text-gray-600 leading-relaxed">
                    Akses khusus untuk pengelolaan data pemerintah dengan sistem keamanan tingkat tinggi dan fitur kolaborasi terintegrasi
                </p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-blue-500">
                <div class="bg-gradient-to-br from-blue-100 to-blue-50 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Admin Control</h3>
                <p class="text-gray-600 leading-relaxed">
                    Panel administrasi lengkap untuk mengelola seluruh sistem, user management, dan monitoring aktivitas real-time
                </p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-t-4 border-purple-500">
                <div class="bg-gradient-to-br from-purple-100 to-purple-50 w-16 h-16 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Smart Analytics</h3>
                <p class="text-gray-600 leading-relaxed">
                    Kelola worksheet PSAK dan Scalling dengan sistem kategorisasi otomatis dan analisis data mendalam
                </p>
            </div>
        </div>

        <!-- Info Sections -->
        <div class="grid md:grid-cols-2 gap-8 mb-16">
            <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-2xl shadow-2xl p-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-white opacity-5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold">PSAK Management</h3>
                    </div>
                    <p class="text-red-100 text-lg leading-relaxed">
                        Sistem pengelolaan worksheet berdasarkan standar PSAK dengan fitur kategorisasi lengkap, 
                        validasi otomatis, dan reporting terintegrasi untuk memastikan compliance yang optimal
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl shadow-2xl p-10 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                <div class="absolute bottom-0 left-0 -mb-8 -ml-8 w-40 h-40 bg-white opacity-5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold">Scalling System</h3>
                    </div>
                    <p class="text-purple-100 text-lg leading-relaxed">
                        Platform scalling dengan kategori LOP (Low, Medium, High) untuk analisis yang lebih detail, 
                        tracking progress real-time, dan dashboard visual yang memudahkan pengambilan keputusan
                    </p>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="bg-white rounded-2xl shadow-2xl p-12 border-t-4 border-red-600">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-800 mb-3">Kenapa Memilih Platform Kami?</h2>
                <p class="text-gray-600">Solusi terpercaya untuk manajemen kertas kerja Anda</p>
            </div>
            <div class="grid md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 mb-2">100%</div>
                    <div class="text-gray-600 font-medium">Secure & Reliable</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 mb-2">24/7</div>
                    <div class="text-gray-600 font-medium">System Availability</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 mb-2">Fast</div>
                    <div class="text-gray-600 font-medium">Performance</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-red-600 mb-2">Easy</div>
                    <div class="text-gray-600 font-medium">To Use</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-10 w-auto mb-4 brightness-0 invert">
                    <p class="text-gray-400 text-sm">
                        Platform manajemen kertas kerja terintegrasi untuk meningkatkan efisiensi dan produktivitas kerja Anda.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="{{ route('login.show') }}" class="hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li>Email: info@telkom.co.id</li>
                        <li>Phone: +62 xxx xxxx</li>
                        <li>Support: 24/7 Available</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} PT Telkom Indonesia. All rights reserved. | Kertas Kerja Management System v1.0</p>
            </div>
        </div>
    </footer>
</div>
@endsection
