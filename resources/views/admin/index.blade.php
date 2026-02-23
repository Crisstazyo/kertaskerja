@extends('layouts.app')

@section('title', 'Admin Dashboard - Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">👨‍💼 Admin Dashboard</h1>
                    <p class="text-gray-600 text-lg">Kertas Kerja Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        <!-- Entity Management Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Government Management Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-100 hover:border-green-300 transition-all duration-300 transform hover:scale-105">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <div class="flex items-center justify-center space-x-3 mb-2">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <span class="text-4xl">🏛️</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Government</h2>
                            <p class="text-green-100 text-sm">Pemerintah</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk instansi pemerintah</p>
                    <div class="space-y-3">
                        <!-- Scalling Button -->
                        <a href="{{ route('admin.lop.type-select', 'government') }}" class="block">
                            <div class="border-2 border-green-200 rounded-lg p-4 hover:border-green-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">📊</span>
                                    <div class="text-left">
                                        <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                        <p class="text-xs text-gray-600">Manage Data</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Private Management Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 transform hover:scale-105">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="flex items-center justify-center space-x-3 mb-2">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <span class="text-4xl">🏢</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Private</h2>
                            <p class="text-blue-100 text-sm">Swasta</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk perusahaan swasta</p>
                    <div class="space-y-3">
                        <!-- Scalling Button -->
                        <a href="{{ route('admin.lop.type-select', 'private') }}" class="block">
                            <div class="border-2 border-blue-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">📊</span>
                                    <div class="text-left">
                                        <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                        <p class="text-xs text-gray-600">Manage Data</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SOE Management Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100 hover:border-purple-300 transition-all duration-300 transform hover:scale-105">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                    <div class="flex items-center justify-center space-x-3 mb-2">
                        <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                            <span class="text-4xl">🏭</span>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">SOE</h2>
                            <p class="text-purple-100 text-sm">BUMN</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk BUMN</p>
                    <div class="space-y-3">
                        <!-- Scalling Button -->
                        <a href="{{ route('admin.lop.type-select', 'soe') }}" class="block">
                            <div class="border-2 border-purple-200 rounded-lg p-4 hover:border-purple-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200">
                                <div class="flex items-center justify-center space-x-3">
                                    <span class="text-3xl">📊</span>
                                    <div class="text-left">
                                        <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                        <p class="text-xs text-gray-600">Manage Data</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Section -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-2 border-gray-100">
            <div class="flex items-start space-x-4">
                <div class="bg-blue-100 p-3 rounded-lg">
                    <span class="text-3xl">💡</span>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Panduan Penggunaan</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Pilih entity (Government/Private/SOE) untuk memulai</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Pilih tipe data (Scalling atau PSAK)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Untuk Scalling: Pilih kategori LOP (On Hand, Qualified, Koreksi, atau Initiate)</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Import Excel untuk On Hand, Qualified, dan Koreksi secara bersamaan</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Tambah data manual untuk LOP Initiate</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection