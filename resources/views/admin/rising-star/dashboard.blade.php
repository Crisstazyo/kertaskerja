@extends('layouts.app')

@section('title', 'Admin - Rising Star Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-amber-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-yellow-600 hover:text-yellow-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke Admin Dashboard
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">⭐ Rising Star Management</h1>
                    <p class="text-gray-600">Admin mengelola seluruh data Rising Star Program semua user</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-500 rounded-full"></div>
        </div>

        <!-- Bintang 1 - Visiting -->
        <div class="mb-10">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-2 rounded-lg shadow mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Rising Star 1 — Visiting Management</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <a href="{{ route('admin.rising-star.feature', 'visiting-gm') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-blue-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">GM</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Visiting GM</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data visiting General Manager</p>
                    <div class="flex items-center text-blue-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
                <a href="{{ route('admin.rising-star.feature', 'visiting-am') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-green-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">AM</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Visiting AM</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data visiting Area Manager</p>
                    <div class="flex items-center text-green-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
                <a href="{{ route('admin.rising-star.feature', 'visiting-hotd') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-purple-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded-full">HOTD</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Visiting HOTD</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data visiting Head of TD</p>
                    <div class="flex items-center text-purple-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bintang 2 - Profiling -->
        <div class="mb-10">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 p-2 rounded-lg shadow mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Rising Star 2 — Profiling Management</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <a href="{{ route('admin.rising-star.feature', 'profiling-maps-am') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-teal-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-teal-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                        </div>
                        <span class="bg-teal-100 text-teal-700 text-xs font-bold px-2 py-1 rounded-full">Maps AM</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Profiling Maps AM</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data profiling maps area manager</p>
                    <div class="flex items-center text-teal-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
                <a href="{{ route('admin.rising-star.feature', 'profiling-overall-hotd') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-indigo-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-2 py-1 rounded-full">HOTD</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Profiling Overall HOTD</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data profiling overall head of TD</p>
                    <div class="flex items-center text-indigo-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bintang 3 - Kecukupan LOP -->
        <div class="mb-10">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-red-400 to-red-500 p-2 rounded-lg shadow mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Rising Star 3 — Kecukupan LOP</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-1 gap-5">
                <a href="{{ route('admin.rising-star.feature', 'kecukupan-lop') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-red-300 transform hover:-translate-y-1 max-w-sm">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-red-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="bg-red-100 text-red-700 text-xs font-bold px-2 py-1 rounded-full">LOP</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Kecukupan LOP</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data kecukupan LOP</p>
                    <div class="flex items-center text-red-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bintang 4 - Asodomoro -->
        <div class="mb-10">
            <div class="flex items-center mb-4">
                <div class="bg-gradient-to-r from-pink-400 to-pink-500 p-2 rounded-lg shadow mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Rising Star 4 — Asodomoro Terpadu</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <a href="{{ route('admin.rising-star.feature', 'asodomoro-0-3-bulan') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-pink-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-pink-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="bg-pink-100 text-pink-700 text-xs font-bold px-2 py-1 rounded-full">0-3 Bulan</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Asodomoro 0-3 Bulan</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data asodomoro 0-3 bulan</p>
                    <div class="flex items-center text-pink-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
                <a href="{{ route('admin.rising-star.feature', 'asodomoro-above-3-bulan') }}" class="group bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-rose-300 transform hover:-translate-y-1">
                    <div class="flex items-start justify-between mb-3">
                        <div class="bg-rose-100 p-2.5 rounded-lg">
                            <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="bg-rose-100 text-rose-700 text-xs font-bold px-2 py-1 rounded-full">>3 Bulan</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1">Asodomoro >3 Bulan</h3>
                    <p class="text-gray-500 text-sm mb-3">Kelola data asodomoro di atas 3 bulan</p>
                    <div class="flex items-center text-rose-600 text-sm font-semibold">
                        Kelola Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
