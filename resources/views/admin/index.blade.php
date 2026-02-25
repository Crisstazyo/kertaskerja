@extends('layouts.app')

@section('title', 'Admin Dashboard - Management')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard</h1>
                    <p class="text-gray-600">Kertas Kerja Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                     Logout
                    </button>
                </form>
            </div>
            <div class="h-px bg-gray-200"></div>
        </div>

        <!-- LOP Management Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                LOP Management
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Government Management Card -->
                <a href="{{ route('admin.role.menu', 'government') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-green-500 hover:shadow-md transition-all">
                    <div class="bg-green-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">Government</h2>
                        <p class="text-green-100 text-sm mt-1">Pemerintah</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Upload & Lihat Progress</p>
                        <p class="text-gray-600 text-sm">Kelola data LOP Government</p>
                    </div>
                </a>

                <!-- Private Management Card -->
                <a href="{{ route('admin.role.menu', 'private') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all">
                    <div class="bg-blue-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">Private</h2>
                        <p class="text-blue-100 text-sm mt-1">Swasta</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Upload & Lihat Progress</p>
                        <p class="text-gray-600 text-sm">Kelola data LOP Private</p>
                    </div>
                </a>

                <!-- SOE Management Card -->
                <a href="{{ route('admin.role.menu', 'soe') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-purple-500 hover:shadow-md transition-all">
                    <div class="bg-purple-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">SOE</h2>
                        <p class="text-purple-100 text-sm mt-1">BUMN</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Upload & Lihat Progress</p>
                        <p class="text-gray-600 text-sm">Kelola data LOP SOE</p>
                    </div>
                </a>

                <!-- SME Management Card -->
                <a href="{{ route('admin.role.menu', 'sme') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-orange-500 hover:shadow-md transition-all">
                    <div class="bg-orange-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">SME</h2>
                        <p class="text-orange-100 text-sm mt-1">UKM</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Upload & Lihat Progress</p>
                        <p class="text-gray-600 text-sm">Kelola data LOP SME</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Special Programs Section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                Special Programs & Monitoring
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Collection Management Card -->
                <a href="{{ route('admin.special.dashboard', 'collection') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-pink-500 hover:shadow-md transition-all">
                    <div class="bg-pink-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">Collection</h2>
                        <p class="text-pink-100 text-sm mt-1">Monitoring Collection</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Lihat Data & Activity</p>
                        <p class="text-gray-600 text-sm">Monitor user activity dengan timestamp</p>
                    </div>
                </a>

                <!-- CTC Management Card -->
                <a href="{{ route('admin.special.dashboard', 'ctc') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-cyan-500 hover:shadow-md transition-all">
                    <div class="bg-cyan-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">CTC</h2>
                        <p class="text-cyan-100 text-sm mt-1">Combat The Churn</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Lihat Data & Activity</p>
                        <p class="text-gray-600 text-sm">Monitor user activity dengan timestamp</p>
                    </div>
                </a>

                <!-- Rising Star Management Card -->
                <a href="{{ route('admin.special.dashboard', 'rising-star') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-yellow-500 hover:shadow-md transition-all">
                    <div class="bg-yellow-600 p-6 text-white rounded-t-lg">
                        <h2 class="text-xl font-semibold">Rising Star</h2>
                        <p class="text-yellow-100 text-sm mt-1">Rising Star Program</p>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-900 font-medium mb-2">Lihat Data & Activity</p>
                        <p class="text-gray-600 text-sm">Monitor user activity dengan timestamp</p>
                    </div>
                </a>
            </div>
        </div>

@endsection