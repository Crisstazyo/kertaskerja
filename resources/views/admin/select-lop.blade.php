@extends('layouts.app')

@section('title', 'Pilih LOP - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('admin.select-role', $role) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block">
                        ← Kembali ke Pilih Tipe
                    </a>
                    <h1 class="text-4xl font-bold text-gray-800">
                        @if($role === 'government') 🏛️ @endif
                        @if($role === 'private') 🏢 @endif
                        @if($role === 'soe') 🏭 @endif
                        {{ ucfirst($role) }} - Scalling
                    </h1>
                    <p class="text-gray-600 mt-2">Pilih kategori LOP yang ingin dikelola</p>
                </div>
            </div>
        </div>

        <!-- LOP Category Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- LOP On Hand -->
            <a href="{{ route('admin.lop-manage', [$role, 'scalling', 'on_hand']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 text-white">
                    <div class="text-5xl mb-3">✅</div>
                    <h2 class="text-2xl font-bold mb-1">LOP On Hand</h2>
                    <p class="text-emerald-100 text-sm">F5 - On Hand</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-emerald-600 group-hover:text-emerald-700">
                        <span class="font-semibold text-sm">Kelola</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- LOP Qualified -->
            <a href="{{ route('admin.lop-manage', [$role, 'scalling', 'qualified']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-6 text-white">
                    <div class="text-5xl mb-3">⭐</div>
                    <h2 class="text-2xl font-bold mb-1">LOP Qualified</h2>
                    <p class="text-green-100 text-sm">F3-F4 - Qualified</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-green-600 group-hover:text-green-700">
                        <span class="font-semibold text-sm">Kelola</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- LOP Initiate (Hidden for Government) -->
            @if($role !== 'government')
            <a href="{{ route('admin.lop-manage', [$role, 'scalling', 'initiate']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-6 text-white">
                    <div class="text-5xl mb-3">🚀</div>
                    <h2 class="text-2xl font-bold mb-1">LOP Initiate</h2>
                    <p class="text-yellow-100 text-sm">F0-F2 - Initiate</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-yellow-600 group-hover:text-yellow-700">
                        <span class="font-semibold text-sm">Kelola</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
            @endif

            <!-- LOP Koreksi -->
            <a href="{{ route('admin.lop-manage', [$role, 'scalling', 'koreksi']) }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-red-500 to-red-600 p-6 text-white">
                    <div class="text-5xl mb-3">🔄</div>
                    <h2 class="text-2xl font-bold mb-1">LOP Koreksi</h2>
                    <p class="text-red-100 text-sm">Koreksi Data</p>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between text-red-600 group-hover:text-red-700">
                        <span class="font-semibold text-sm">Kelola</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
