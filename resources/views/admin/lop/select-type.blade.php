@extends('layouts.app')

@section('title', 'Pilih Tipe - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.dashboard') }}" class="mr-4 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📊 Pilih Tipe Data</h1>
                    <p class="text-gray-600 text-lg">{{ ucfirst($entity) }}</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        <!-- Type Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Scalling Card -->
            <a href="{{ route('admin.lop.category-select', [$entity, 'scalling']) }}" class="block transform hover:scale-105 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-400 cursor-pointer">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="flex items-center justify-center space-x-3">
                            <span class="text-5xl">📊</span>
                            <h2 class="text-3xl font-bold">Scalling</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-center mb-4">Kelola data scalling dengan berbagai kategori LOP</p>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-800 mb-2">Kategori tersedia:</h4>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• LOP On Hand</li>
                                <li>• LOP Qualified</li>
                                <li>• LOP Koreksi</li>
                                <li>• LOP Initiate</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <div class="block opacity-50 pointer-events-none">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center justify-center space-x-3">
                            <span class="text-5xl">📋</span>
                            <h2 class="text-3xl font-bold">PSAK</h2>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 text-center mb-4">Kelola data PSAK</p>
                        <div class="bg-purple-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-semibold text-gray-700">Coming Soon</p>
                            <p class="text-xs text-gray-500 mt-2">Fitur ini akan segera tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
