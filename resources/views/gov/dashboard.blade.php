@extends('layouts.app')

@section('title', 'Government Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-red-100 to-red-50 rounded-full filter blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-blue-100 to-blue-50 rounded-full filter blur-3xl opacity-40 translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Premium Header -->
        <div class="mb-8">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Telkom Logo" class="h-16 w-auto">
                        <div class="border-l-2 border-gray-300 h-16"></div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Government Dashboard</h1>
                            <p class="text-sm text-gray-600 mt-1">Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group relative px-6 py-3 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white rounded-xl font-semibold transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Scalling Card -->
        <div class="mb-10">
            <a href="{{ route('gov.scalling') }}" class="group block">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">📊 Scalling Dashboard</h2>
                                        <p class="text-blue-100 text-sm">Kelola data LOP Government</p>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                                <div class="flex items-center text-blue-100 font-semibold mt-6 group-hover:text-white transition-colors">
                                    <span>Buka Dashboard</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Rising Star Section for Government -->
        <div class="bg-gradient-to-br from-pink-50 to-rose-50 rounded-2xl border-2 border-pink-200 shadow-xl p-8">
            <div class="flex items-center space-x-4 mb-6">
                <div class="bg-gradient-to-br from-pink-500 to-rose-500 p-4 rounded-xl shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-black text-slate-900">Rising Star - Bintang 4</h2>
                    <p class="text-sm text-slate-600 mt-1">Program Asodomoro untuk meningkatkan kinerja Government</p>
                </div>
            </div>

            <div class="bg-pink-100 border-l-4 border-pink-500 rounded-lg p-4 mb-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-5 h-5 text-pink-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <p class="text-sm font-bold text-pink-900 mb-1">Informasi Program</p>
                        <p class="text-xs text-pink-800 leading-relaxed">
                            Target komitmen Asodomoro adalah <strong>70%</strong>. Silakan input data realisasi Anda secara berkala.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Asodomoro 0-3 Bulan -->
                <div class="bg-white rounded-xl p-6 border-2 border-pink-300 shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-900 text-lg">Asodomoro 0-3 Bulan</h3>
                        <span class="bg-pink-100 text-pink-800 text-xs font-black px-3 py-1 rounded-full">0-3 BLN</span>
                    </div>
                    <p class="text-sm text-slate-600 mb-6">Input realisasi data Asodomoro untuk periode 0-3 bulan</p>
                    <a href="{{ route('gov.asodomoro-0-3-bulan') }}" 
                        class="w-full bg-gradient-to-r from-pink-500 to-rose-500 hover:from-pink-600 hover:to-rose-600 text-white font-bold text-sm px-4 py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Input Data Realisasi</span>
                    </a>
                </div>

                <!-- Asodomoro >3 Bulan -->
                <div class="bg-white rounded-xl p-6 border-2 border-rose-300 shadow-md hover:shadow-xl transition-all transform hover:-translate-y-1">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-black text-slate-900 text-lg">Asodomoro >3 Bulan</h3>
                        <span class="bg-purple-100 text-purple-800 text-xs font-black px-3 py-1 rounded-full">>3 BLN</span>
                    </div>
                    <p class="text-sm text-slate-600 mb-6">Input realisasi data Asodomoro untuk periode lebih dari 3 bulan</p>
                    <a href="{{ route('gov.asodomoro-above-3-bulan') }}" 
                        class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold text-sm px-4 py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center space-x-2 group">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Input Data Realisasi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
