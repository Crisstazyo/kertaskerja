@extends('layouts.app')

@section('title', 'Admin Panel')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-4xl font-bold text-gray-800">🛠️ Admin Panel</h1>
                    <p class="text-gray-600 mt-2">Pilih role yang ingin dikelola</p>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition duration-300 shadow-md">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Role Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Government Card -->
            <a href="{{ route('admin.select-role', 'government') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-green-500 to-green-600 p-8 text-white">
                    <div class="text-6xl mb-4">🏛️</div>
                    <h2 class="text-3xl font-bold mb-2">Government</h2>
                    <p class="text-green-100">Kelola worksheet Government</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between text-green-600 group-hover:text-green-700">
                        <span class="font-semibold">Akses Pengelolaan</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Private Card -->
            <a href="{{ route('admin.select-role', 'private') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-8 text-white">
                    <div class="text-6xl mb-4">🏢</div>
                    <h2 class="text-3xl font-bold mb-2">Private</h2>
                    <p class="text-yellow-100">Kelola worksheet Private</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between text-yellow-600 group-hover:text-yellow-700">
                        <span class="font-semibold">Akses Pengelolaan</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- SOE Card -->
            <a href="{{ route('admin.select-role', 'soe') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-8 text-white">
                    <div class="text-6xl mb-4">🏭</div>
                    <h2 class="text-3xl font-bold mb-2">SOE</h2>
                    <p class="text-purple-100">Kelola worksheet SOE</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between text-purple-600 group-hover:text-purple-700">
                        <span class="font-semibold">Akses Pengelolaan</span>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recap Section -->
        <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">📊 Rekap Data</h2>
            <p class="text-gray-600 mb-4">Lihat rekap lengkap semua worksheet per role</p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.recap', ['role' => 'government', 'all']) }}" class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                    <div class="text-xl font-bold">Rekap Government</div>
                </a>
                <a href="{{ route('admin.recap', ['role' => 'private', 'all']) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                    <div class="text-xl font-bold">Rekap Private</div>
                </a>
                <a href="{{ route('admin.recap', ['role' => 'soe', 'all']) }}" class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-6 py-4 rounded-lg shadow-md transition duration-300 text-center">
                    <div class="text-xl font-bold">Rekap SOE</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
