@extends('layouts.app')

@section('title', 'Admin - Scalling Management - ' . ucfirst($roleNormalized))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">← Back to Dashboard</a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Scalling Management - {{ ucfirst($roleNormalized) }}</h1>
                    <p class="text-gray-600">
                        @if($roleNormalized == 'government')
                            Pemerintah - Pilih Kategori LOP
                        @elseif($roleNormalized == 'private')
                            Swasta - Pilih Kategori LOP
                        @elseif($roleNormalized == 'soe')
                            BUMN (SOE) - Pilih Kategori LOP
                        @elseif($roleNormalized == 'sme')
                            UKM (SME) - Pilih Kategori LOP
                        @endif
                    </p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md font-medium transition-colors">
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-green-500 to-teal-500 rounded-full"></div>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md">
            <span class="font-semibold">{{ session('error') }}</span>
        </div>
        @endif

        <!-- SME Specific Links -->
        @if($roleNormalized == 'sme')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
            <a href="{{ route('admin.scalling.hsi-agency') }}" class="group bg-white rounded-lg shadow-sm border-2 border-gray-200 hover:border-orange-500 hover:shadow-lg transition-all p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">HSI Agency</h3>
                            <p class="text-sm text-gray-600">Input & View HSI Agency Data</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-orange-600 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            <a href="{{ route('admin.scalling.telda') }}" class="group bg-white rounded-lg shadow-sm border-2 border-gray-200 hover:border-orange-500 hover:shadow-lg transition-all p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="bg-gradient-to-br from-orange-600 to-orange-700 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Scaling Telda</h3>
                            <p class="text-sm text-gray-600">Input & View Telda Data</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-orange-600 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        </div>
        @endif

        <!-- LOP Categories Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center space-x-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span>Pilih Kategori LOP</span>
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- LOP On Hand -->
                <a href="{{ route('admin.scalling.lop', [$role, 'on-hand']) }}" 
                   class="group bg-gradient-to-br from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">LOP On Hand</h3>
                    <p class="text-blue-100 text-sm">Manage LOP On Hand data, upload files, dan lihat progress</p>
                </a>

                <!-- LOP Qualified -->
                <a href="{{ route('admin.scalling.lop', [$role, 'qualified']) }}" 
                   class="group bg-gradient-to-br from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">LOP Qualified</h3>
                    <p class="text-green-100 text-sm">Manage LOP Qualified data, upload files, dan lihat progress</p>
                </a>

                <!-- Koreksi -->
                <a href="{{ route('admin.scalling.lop', [$role, 'koreksi']) }}" 
                   class="group bg-gradient-to-br from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Koreksi</h3>
                    <p class="text-purple-100 text-sm">Manage Koreksi data, upload files, dan lihat progress</p>
                </a>

                <!-- LOP Initiate -->
                <a href="{{ route('admin.scalling.lop', [$role, 'initiate']) }}" 
                   class="group bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-md hover:shadow-xl transition-all duration-300 p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-2">LOP Initiate</h3>
                    <p class="text-orange-100 text-sm">Manage LOP Initiate data, upload files, dan lihat progress</p>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection