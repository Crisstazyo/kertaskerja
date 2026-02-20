@extends('layouts.app')

@section('title', 'Pilih Tipe - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Kembali ke Admin Panel
                    </a>
                    <h1 class="text-4xl font-bold text-gray-800">
                        @if($role === 'government') 🏛️ @endif
                        @if($role === 'private') 🏢 @endif
                        @if($role === 'soe') 🏭 @endif
                        {{ ucfirst($role) }}
                    </h1>
                    <p class="text-gray-600 mt-2">Pilih tipe worksheet yang ingin dikelola</p>
                </div>
            </div>
        </div>

        <!-- Type Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Scalling Card -->
            <a href="{{ route('admin.select-type', [$role, 'scalling']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white">
                    <div class="text-6xl mb-4">📈</div>
                    <h2 class="text-3xl font-bold mb-2">Scalling</h2>
                    <p class="text-blue-100">Kelola worksheet Scalling dengan kategori LOP</p>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Kategori LOP:</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• LOP On Hand</li>
                            <li>• LOP Qualified</li>
                            @if($role !== 'government')
                            <li>• LOP Initiate</li>
                            @endif
                            <li>• LOP Koreksi</li>
                        </ul>
                    </div>
                    <div class="flex items-center justify-between text-blue-600 group-hover:text-blue-700">
                        <span class="font-semibold">Pilih Kategori LOP</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <a href="{{ route('admin.select-type', [$role, 'psak']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-8 text-white">
                    <div class="text-6xl mb-4">📊</div>
                    <h2 class="text-3xl font-bold mb-2">PSAK</h2>
                    <p class="text-green-100">Kelola worksheet PSAK</p>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Fitur:</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Tambah tabel worksheet</li>
                            <li>• Lihat data worksheet</li>
                            <li>• Lihat riwayat worksheet</li>
                        </ul>
                    </div>
                    <div class="flex items-center justify-between text-green-600 group-hover:text-green-700">
                        <span class="font-semibold">Kelola PSAK</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
