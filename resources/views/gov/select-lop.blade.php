@extends('layouts.app')

@section('title', 'Pilih Kategori LOP - ' . ucfirst($type))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="text-6xl mb-4">{{ $type === 'scalling' ? '📊' : '📋' }}</div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ ucfirst($type) }} - Government</h1>
            <p class="text-gray-600">Pilih kategori LOP yang ingin Anda kelola</p>
        </div>

        <!-- LOP Categories -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Low -->
            <a href="{{ route('gov.lop-manage', [$type, 'low']) }}" 
               class="group bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-green-500">
                <div class="text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform">🟢</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-green-600">Low</h3>
                    <p class="text-gray-600 mb-4">Kategori risiko rendah</p>
                    <div class="text-green-600 font-semibold">Pilih →</div>
                </div>
            </a>

            <!-- Medium -->
            <a href="{{ route('gov.lop-manage', [$type, 'medium']) }}" 
               class="group bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-yellow-500">
                <div class="text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform">🟡</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-yellow-600">Medium</h3>
                    <p class="text-gray-600 mb-4">Kategori risiko menengah</p>
                    <div class="text-yellow-600 font-semibold">Pilih →</div>
                </div>
            </a>

            <!-- High -->
            <a href="{{ route('gov.lop-manage', [$type, 'high']) }}" 
               class="group bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-red-500">
                <div class="text-center">
                    <div class="text-6xl mb-4 transform group-hover:scale-110 transition-transform">🔴</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-red-600">High</h3>
                    <p class="text-gray-600 mb-4">Kategori risiko tinggi</p>
                    <div class="text-red-600 font-semibold">Pilih →</div>
                </div>
            </a>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-12">
            <a href="{{ route('gov.select-type') }}" 
               class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-300 inline-block">
                ← Kembali
            </a>
        </div>
    </div>
</div>
@endsection
