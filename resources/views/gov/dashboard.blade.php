@extends('layouts.app')

@section('title', 'Government Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">🏛️ Government Dashboard</h1>
                    <p class="text-gray-600 text-lg">Kertas Kerja Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-green-500 via-blue-500 to-teal-500 rounded-full"></div>
        </div>

        <!-- Data Management Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- LOP On Hand Card -->
            <a href="{{ route('gov.lop-on-hand') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-100 hover:border-green-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📊</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">LOP On Hand</h2>
                                <p class="text-green-100">View Data Tables</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">View LOP On Hand data uploaded by admin</p>
                        <div class="flex items-center text-green-600 font-semibold">
                            <span>Open LOP On Hand</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Scalling Card -->
            <a href="{{ route('gov.scalling') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📈</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Scalling</h2>
                                <p class="text-blue-100">Data Tables & Forms</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">View data uploaded by admin and fill required forms</p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            <span>Open Scalling</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <div class="group opacity-50 pointer-events-none">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100">
                    <div class="bg-gradient-to-r from-purple-400 to-purple-500 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📋</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">PSAK</h2>
                                <p class="text-purple-100">Coming Soon</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">PSAK management feature is under development</p>
                        <div class="flex items-center text-gray-400 font-semibold">
                            <span>Not Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
