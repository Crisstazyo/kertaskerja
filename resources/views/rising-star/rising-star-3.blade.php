@extends('layouts.app')

@section('title', 'Rising Star 3')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">⭐ Rising Star 3</h1>
                    <p class="text-gray-600 text-lg">Kecukupan LOP Management</p>
                </div>
                <a href="{{ route('rising-star.dashboard') }}" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-600 rounded-full"></div>
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-l-4 border-red-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-lg font-bold text-gray-900">Kecukupan LOP Management</h3>
                    <p class="text-sm text-gray-600">Kelola data kecukupan LOP (List of Personnel)</p>
                </div>
            </div>
        </div>

        <!-- Menu Card -->
        <div class="max-w-md mx-auto mb-8">
            <!-- Kecukupan LOP Card -->
            <a href="{{ route('rising-star.kecukupan-lop') }}" class="group block">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-red-400">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-red-400 to-red-500 p-4 rounded-lg shadow-md">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">📋 Kecukupan LOP</h2>
                    <p class="text-gray-600">Kelola kecukupan List of Personnel</p>
                </div>
            </a>
        </div>

        <!-- Footer Info -->
        <div class="bg-gradient-to-r from-red-500 via-orange-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">📊 LOP Monitoring</h3>
                    <p class="text-red-100">Klik menu di atas untuk mengelola kecukupan LOP</p>
                </div>
                <div class="text-right">
                    <p class="text-2xl font-bold">110%</p>
                    <p class="text-sm text-red-100">Target Ratio</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
