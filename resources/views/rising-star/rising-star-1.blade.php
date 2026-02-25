@extends('layouts.app')

@section('title', 'Rising Star 1')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 via-orange-50 to-red-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">⭐ Rising Star 1</h1>
                    <p class="text-gray-600 text-lg">Visiting Management - GM, AM & HOTD</p>
                </div>
                <a href="{{ route('rising-star.dashboard') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Kembali
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-yellow-500 via-orange-500 to-red-600 rounded-full"></div>
        </div>

        <!-- Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-lg font-bold text-gray-900">Visiting Management</h3>
                    <p class="text-sm text-gray-600">Kelola visiting untuk GM, AM, dan HOTD</p>
                </div>
            </div>
        </div>

        <!-- Menu Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Visiting GM Card -->
            <a href="{{ route('rising-star.visiting-gm') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-blue-400">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-blue-400 to-blue-500 p-4 rounded-lg shadow-md">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">👔 Visiting GM</h2>
                    <p class="text-gray-600">Kelola visiting General Manager</p>
                </div>
            </a>

            <!-- Visiting AM Card -->
            <a href="{{ route('rising-star.visiting-am') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-green-400">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-green-400 to-green-500 p-4 rounded-lg shadow-md">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-green-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">👨‍💼 Visiting AM</h2>
                    <p class="text-gray-600">Kelola visiting Area Manager</p>
                </div>
            </a>

            <!-- Visiting HOTD Card -->
            <a href="{{ route('rising-star.visiting-hotd') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-400">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-gradient-to-br from-purple-400 to-purple-500 p-4 rounded-lg shadow-md">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">🎯 Visiting HOTD</h2>
                    <p class="text-gray-600">Kelola visiting Head of TD</p>
                </div>
            </a>
        </div>

        <!-- Footer Info -->
        <div class="bg-gradient-to-r from-blue-500 via-green-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2">📊 Visiting Monitoring</h3>
                    <p class="text-blue-100">Pilih salah satu menu di atas untuk mengelola visiting</p>
                </div>
                <div class="text-6xl opacity-20">👥</div>
            </div>
        </div>
    </div>
</div>
@endsection
