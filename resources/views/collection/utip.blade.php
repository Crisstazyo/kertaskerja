@extends('layouts.app')

@section('title', 'UTIP Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-4xl font-bold text-gray-900">📊 UTIP Management</h1>
                <a href="{{ route('collection.dashboard') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-4 py-2 rounded-lg font-medium shadow-sm border border-gray-200 transition-all">
                    ← Kembali ke Dashboard
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- Info Banner -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-r-lg mb-8">
            <div class="flex items-center">
                <div class="text-3xl mr-4">💡</div>
                <div>
                    <p class="text-blue-900 font-bold text-lg">Pilih Menu UTIP</p>
                    <p class="text-sm text-blue-700 mt-1">
                        Kelola data <strong>UTIP Corrective</strong> untuk perbaikan atau <strong>New UTIP</strong> dengan filter periode bulan/tahun.
                    </p>
                </div>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- UTIP Corrective Card -->
            <a href="{{ route('collection.utip-corrective') }}" class="group block">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-100 hover:border-orange-300 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-orange-500 to-red-600 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-5xl">🔧</div>
                            <div class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <span class="text-xs font-bold uppercase">Corrective</span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">UTIP Corrective</h3>
                        <p class="text-orange-100 text-sm">Data perbaikan dan koreksi UTIP</p>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-orange-50 to-red-50">
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Form Komitmen & Realisasi
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Periode Bulan Berjalan
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Tracking Persentase
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end text-orange-600 font-bold group-hover:text-orange-700">
                            <span>Akses Menu</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- New UTIP Card -->
            <a href="{{ route('collection.utip-new') }}" class="group block">
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-100 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-2 hover:shadow-2xl">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-5xl">✨</div>
                            <div class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">
                                <span class="text-xs font-bold uppercase">New</span>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold mb-2">New UTIP</h3>
                        <p class="text-blue-100 text-sm">Data UTIP baru dengan filter periode</p>
                    </div>
                    <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50">
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter Bulan & Tahun
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Input Data Per Periode
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                History Per Bulan
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end text-blue-600 font-bold group-hover:text-blue-700">
                            <span>Akses Menu</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        
            
    </div>
</div>
@endsection
