@extends('layouts.app')

@section('title', 'Menu Dashboard ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center py-12 px-4">
    <div class="max-w-4xl w-full">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-white mb-2">Dashboard {{ ucfirst($role) }}</h1>
            <p class="text-blue-100">Selamat datang, {{ auth()->user()->name }}</p>
            <form action="{{ route('logout') }}" method="POST" class="mt-4 inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-300">
                    Logout
                </button>
            </form>
        </div>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- SCALLING Card -->
            <a href="{{ route('scalling.index') }}" class="group">
                <div class="bg-white rounded-xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                    <div class="flex flex-col items-center justify-center h-64">
                        <div class="mb-6">
                            <svg class="w-24 h-24 text-blue-600 group-hover:text-blue-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">SCALLING</h2>
                        <p class="text-gray-600 text-center">Kelola data kertas kerja scalling</p>
                        <div class="mt-6 bg-blue-100 text-blue-700 px-4 py-2 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            Masuk →
                        </div>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <a href="{{ route('psak.index') }}" class="group">
                <div class="bg-white rounded-xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-105 hover:shadow-3xl">
                    <div class="flex flex-col items-center justify-center h-64">
                        <div class="mb-6">
                            <svg class="w-24 h-24 text-green-600 group-hover:text-green-700 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-gray-800 mb-3">PSAK</h2>
                        <p class="text-gray-600 text-center">Kelola data kertas kerja PSAK</p>
                        <div class="mt-6 bg-green-100 text-green-700 px-4 py-2 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors">
                            Masuk →
                        </div>
                    </div>
                </div>
            </a>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="mt-8 text-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg transition duration-300 shadow-lg">
                🛠️ Admin Panel
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
