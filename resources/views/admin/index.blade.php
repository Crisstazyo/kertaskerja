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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Government Management Card -->
            <a href="{{ route('admin.role.menu', 'government') }}" class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-100 hover:border-green-400 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-2xl inline-block mb-3">
                            <span class="text-5xl">🏛️</span>
                        </div>
                        <h2 class="text-2xl font-bold">Government</h2>
                        <p class="text-green-100 text-sm mt-1">Pemerintah</p>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-700 font-semibold">Upload & Lihat Progress</p>
                    <p class="text-gray-500 text-sm mt-2">Kelola data LOP Government</p>
                </div>
            </a>

            <!-- Private Management Card -->
            <a href="{{ route('admin.role.menu', 'private') }}" class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-400 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-2xl inline-block mb-3">
                            <span class="text-5xl">🏢</span>
                        </div>
                        <h2 class="text-2xl font-bold">Private</h2>
                        <p class="text-blue-100 text-sm mt-1">Swasta</p>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-700 font-semibold">Upload & Lihat Progress</p>
                    <p class="text-gray-500 text-sm mt-2">Kelola data LOP Private</p>
                </div>
            </a>

            <!-- SOE Management Card -->
            <a href="{{ route('admin.role.menu', 'soe') }}" class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100 hover:border-purple-400 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-2xl inline-block mb-3">
                            <span class="text-5xl">🏭</span>
                        </div>
                        <h2 class="text-2xl font-bold">SOE</h2>
                        <p class="text-purple-100 text-sm mt-1">BUMN</p>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-700 font-semibold">Upload & Lihat Progress</p>
                    <p class="text-gray-500 text-sm mt-2">Kelola data LOP SOE</p>
                </div>
            </a>

            <!-- SME Management Card -->
            <a href="{{ route('admin.role.menu', 'sme') }}" class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-orange-100 hover:border-orange-400 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6 text-white">
                    <div class="text-center">
                        <div class="bg-white bg-opacity-20 p-4 rounded-2xl inline-block mb-3">
                            <span class="text-5xl">🏪</span>
                        </div>
                        <h2 class="text-2xl font-bold">SME</h2>
                        <p class="text-orange-100 text-sm mt-1">UKM</p>
                    </div>
                </div>
                <div class="p-6 text-center">
                    <p class="text-gray-700 font-semibold">Upload & Lihat Progress</p>
                    <p class="text-gray-500 text-sm mt-2">Kelola data LOP SME</p>
                </div>
            </a>
        </div>

@endsection