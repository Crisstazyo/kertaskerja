@extends('layouts.app')

@section('title', 'Pilih Kategori LOP - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center mb-4">
                <a href="{{ route('admin.lop.type-select', $entity) }}" class="mr-4 text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📂 Pilih Kategori LOP</h1>
                    <p class="text-gray-600 text-lg">{{ ucfirst($entity) }} - {{ ucfirst($type) }}</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        <!-- LOP Category Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- LOP On Hand -->
            <a href="{{ route('admin.lop.on_hand', $entity) }}" class="block transform hover:scale-105 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-100 hover:border-green-400 cursor-pointer h-full">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                        <div class="text-center">
                            <span class="text-5xl mb-2 block">📊</span>
                            <h3 class="text-xl font-bold">LOP On Hand</h3>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col justify-between">
                        <p class="text-gray-600 text-center mb-4">Import data dari Excel</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Upload Excel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>View data tabel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Lihat history</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Qualified -->
            <a href="{{ route('admin.lop.qualified', $entity) }}" class="block transform hover:scale-105 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-400 cursor-pointer h-full">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="text-center">
                            <span class="text-5xl mb-2 block">✅</span>
                            <h3 class="text-xl font-bold">LOP Qualified</h3>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col justify-between">
                        <p class="text-gray-600 text-center mb-4">Import data dari Excel</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Upload Excel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>View data tabel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Lihat history</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Koreksi -->
            <a href="{{ route('admin.lop.koreksi', $entity) }}" class="block transform hover:scale-105 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-orange-100 hover:border-orange-400 cursor-pointer h-full">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                        <div class="text-center">
                            <span class="text-5xl mb-2 block">🔄</span>
                            <h3 class="text-xl font-bold">LOP Koreksi</h3>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col justify-between">
                        <p class="text-gray-600 text-center mb-4">Import data dari Excel</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Upload Excel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>View data tabel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Lihat history</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Initiate -->
            <a href="{{ route('admin.lop.initiate', $entity) }}" class="block transform hover:scale-105 transition-all duration-300">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100 hover:border-purple-400 cursor-pointer h-full">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                        <div class="text-center">
                            <span class="text-5xl mb-2 block">🚀</span>
                            <h3 class="text-xl font-bold">LOP Initiate</h3>
                        </div>
                    </div>
                    <div class="p-6 flex flex-col justify-between">
                        <p class="text-gray-600 text-center mb-4">Tambah data manual</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Tambah data baru</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>View data tabel</span>
                            </div>
                            <div class="flex items-start">
                                <span class="mr-2">✓</span>
                                <span>Lihat history</span>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Info Box -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-2 border-gray-100">
            <div class="flex items-start space-x-4">
                <div class="bg-yellow-100 p-3 rounded-lg">
                    <span class="text-3xl">💡</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Catatan Penting</h3>
                    <p class="text-gray-600 mb-2">Untuk <strong>LOP On Hand, Qualified, dan Koreksi</strong>: Satu kali import Excel akan memasukkan data ke ketiga tabel sekaligus.</p>
                    <p class="text-gray-600">Untuk <strong>LOP Initiate</strong>: Data dapat ditambahkan secara manual oleh user dengan format tabel yang sama.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
