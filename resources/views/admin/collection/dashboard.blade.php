@extends('layouts.app')

@section('title', 'Admin - Collection Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-white to-rose-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-pink-600 hover:text-pink-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke Admin Dashboard
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">💎 Collection Management</h1>
                    <p class="text-gray-600">Admin mengelola seluruh data Collection semua user</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-pink-500 via-rose-500 to-fuchsia-500 rounded-full"></div>
        </div>

        <!-- Feature Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">

            <!-- C3MR -->
            <a href="{{ route('admin.collection.c3mr') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pink-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-pink-500 to-rose-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-pink-100 p-3 rounded-xl group-hover:bg-pink-200 transition-colors">
                            <svg class="w-7 h-7 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">C3MR</h2>
                            <p class="text-gray-500 text-sm">Collection Management</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Kelola data C3MR komitmen & realisasi semua user collection</p>
                    <div class="mt-4 flex items-center text-pink-600 font-semibold text-sm group-hover:text-pink-700">
                        Manage Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            <!-- Billing Perdanan -->
            <a href="{{ route('admin.collection.billing') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-rose-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-rose-500 to-red-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-rose-100 p-3 rounded-xl group-hover:bg-rose-200 transition-colors">
                            <svg class="w-7 h-7 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Billing Perdanan</h2>
                            <p class="text-gray-500 text-sm">Billing Management</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Kelola data Billing Perdanan komitmen & realisasi semua user collection</p>
                    <div class="mt-4 flex items-center text-rose-600 font-semibold text-sm group-hover:text-rose-700">
                        Manage Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            <!-- Collection Ratio -->
            <a href="{{ route('admin.collection.collection-ratio') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-fuchsia-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-fuchsia-500 to-purple-600 h-2"></div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-fuchsia-100 p-3 rounded-xl group-hover:bg-fuchsia-200 transition-colors">
                            <svg class="w-7 h-7 text-fuchsia-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">Collection Ratio</h2>
                            <p class="text-gray-500 text-sm">GOV / PRIVATE / SME / SOE</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Kelola data Collection Ratio per segmen untuk semua user collection</p>
                    <div class="mt-4 flex flex-wrap gap-1">
                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">GOV</span>
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-semibold">PRIVATE</span>
                        <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs rounded-full font-semibold">SME</span>
                        <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-xs rounded-full font-semibold">SOE</span>
                    </div>
                    <div class="mt-3 flex items-center text-fuchsia-600 font-semibold text-sm group-hover:text-fuchsia-700">
                        Manage Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

            <!-- UTIP -->
            <a href="{{ route('admin.collection.utip') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pink-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-pink-600 to-fuchsia-700 h-2"></div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-pink-100 p-3 rounded-xl group-hover:bg-pink-200 transition-colors">
                            <svg class="w-7 h-7 text-pink-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900">UTIP</h2>
                            <p class="text-gray-500 text-sm">New & Corrective</p>
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm">Kelola data UTIP New dan UTIP Corrective semua user collection</p>
                    <div class="mt-4 flex flex-wrap gap-1">
                        <span class="px-2 py-0.5 bg-pink-100 text-pink-700 text-xs rounded-full font-semibold">New UTIP</span>
                        <span class="px-2 py-0.5 bg-fuchsia-100 text-fuchsia-700 text-xs rounded-full font-semibold">Corrective UTIP</span>
                    </div>
                    <div class="mt-3 flex items-center text-pink-700 font-semibold text-sm group-hover:text-pink-800">
                        Manage Data <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </div>
                </div>
            </a>

        </div>
    </div>
</div>
@endsection
