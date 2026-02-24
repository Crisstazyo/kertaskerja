@extends('layouts.app')

@section('title', ucfirst($lopCategory) . ' - ' . ucfirst($type))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 to-purple-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="text-6xl mb-4">
                @if($lopCategory === 'low') 🟢
                @elseif($lopCategory === 'medium') 🟡
                @else 🔴
                @endif
            </div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                {{ ucfirst($type) }} - {{ ucfirst($lopCategory) }}
            </h1>
            <p class="text-gray-600">SME Panel - Kelola worksheet Anda</p>
        </div>

        <!-- Management Options -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Tambah Worksheet -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="text-6xl mb-4">➕</div>
                    <h3 class="text-2xl font-bold mb-4">Tambah Worksheet</h3>
                    <p class="text-blue-100 mb-6">Buat worksheet baru untuk {{ $type }}</p>
                    <button class="w-full bg-white text-blue-600 font-semibold py-3 rounded-lg hover:bg-blue-50 transition duration-300">
                        Buat Baru
                    </button>
                </div>
            </div>

            <!-- Lihat Data -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="text-6xl mb-4">📊</div>
                    <h3 class="text-2xl font-bold mb-4">Lihat Data</h3>
                    <p class="text-green-100 mb-6">Tampilkan semua worksheet yang ada</p>
                    <button class="w-full bg-white text-green-600 font-semibold py-3 rounded-lg hover:bg-green-50 transition duration-300">
                        Lihat Semua
                    </button>
                </div>
            </div>

            <!-- Riwayat -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-8 text-white hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                <div class="text-center">
                    <div class="text-6xl mb-4">📜</div>
                    <h3 class="text-2xl font-bold mb-4">Riwayat</h3>
                    <p class="text-purple-100 mb-6">Lihat riwayat worksheet</p>
                    <button class="w-full bg-white text-purple-600 font-semibold py-3 rounded-lg hover:bg-purple-50 transition duration-300">
                        Lihat Riwayat
                    </button>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-start space-x-4">
                <div class="text-3xl">ℹ️</div>
                <div>
                    <h4 class="text-lg font-bold text-gray-800 mb-2">Informasi</h4>
                    <p class="text-gray-600">
                        Anda sedang mengelola worksheet <span class="font-semibold">{{ ucfirst($type) }}</span> 
                        dengan kategori <span class="font-semibold">{{ ucfirst($lopCategory) }}</span>. 
                        Pilih salah satu opsi di atas untuk memulai.
                    </p>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-12">
            <a href="{{ route('sme.select-lop', $type) }}" 
               class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-300 inline-block">
                ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
