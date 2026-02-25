@extends('layouts.app')

@section('title', 'Admin - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-8">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="w-full">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium mb-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">{{ ucfirst($role) }} Management</h1>
                        <p class="text-gray-600 mt-1">Pilih aksi yang ingin dilakukan</p>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Action Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Upload File Card -->
            <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-8 text-white">
                    <h2 class="text-3xl font-bold text-center mb-2">Upload File</h2>
                    <p class="text-blue-100 text-center">Pilih kategori LOP untuk upload</p>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-gray-700 mb-4 text-center">Pilih Kategori LOP:</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.upload.category', [$role, 'on_hand']) }}" class="block bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200 hover:border-blue-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP On Hand</h4>
                                    <p class="text-xs text-gray-600">Upload & History</p>
                                </div>
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('admin.upload.category', [$role, 'qualified']) }}" class="block bg-gradient-to-r from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border-2 border-emerald-200 hover:border-emerald-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP Qualified</h4>
                                    <p class="text-xs text-gray-600">Upload & History</p>
                                </div>
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('admin.upload.category', [$role, 'initiate']) }}" class="block bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border-2 border-purple-200 hover:border-purple-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP Initiate</h4>
                                    <p class="text-xs text-gray-600">Upload & History</p>
                                </div>
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- View Progress Card -->
            <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-8 text-white">
                    <h2 class="text-3xl font-bold text-center mb-2">Lihat Progress</h2>
                    <p class="text-emerald-100 text-center">Pilih kategori LOP untuk monitor</p>
                </div>
                <div class="p-6">
                    <h3 class="font-semibold text-gray-700 mb-4 text-center">Pilih Kategori LOP:</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.progress.category', [$role, 'on_hand']) }}" class="block bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 border-2 border-blue-200 hover:border-blue-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP On Hand</h4>
                                    <p class="text-xs text-gray-600">Monitor Progress</p>
                                </div>
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('admin.progress.category', [$role, 'qualified']) }}" class="block bg-gradient-to-r from-emerald-50 to-emerald-100 hover:from-emerald-100 hover:to-emerald-200 border-2 border-emerald-200 hover:border-emerald-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP Qualified</h4>
                                    <p class="text-xs text-gray-600">Monitor Progress</p>
                                </div>
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('admin.progress.category', [$role, 'initiate']) }}" class="block bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border-2 border-purple-200 hover:border-purple-400 rounded-lg p-4 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-bold text-gray-800">LOP Initiate</h4>
                                    <p class="text-xs text-gray-600">Monitor Progress</p>
                                </div>
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PSAK Card -->
        <div class="mt-8">
            <div class="group bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 overflow-hidden border-2 border-gray-100">
                <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-8 text-white">
                    <h2 class="text-3xl font-bold text-center mb-2">PSAK</h2>
                    <p class="text-indigo-100 text-center">Monitor data PSAK per role</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 text-center mb-6">Lihat dan monitor input data PSAK untuk role {{ ucfirst($role) }}</p>
                    <div class="flex justify-center">
                        <a href="{{ route('admin.psak', $role) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-8 py-4 rounded-lg font-bold transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Lihat Data PSAK
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
