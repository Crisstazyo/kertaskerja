@extends('layouts.app')

@section('title', 'Collection Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">💰 Collection Dashboard</h1>
                    <p class="text-gray-600 text-lg">Kertas Kerja Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-500 rounded-full"></div>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <a href="{{ route('collection.c3mr') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100 hover:border-purple-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📊</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">C3MR</h2>
                                <p class="text-purple-100">Customer Credit Management</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Manage customer credit and monitoring reports</p>
                        <div class="flex items-center text-purple-600 font-semibold">
                            <span>Open C3MR</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            
            <a href="{{ route('collection.billing-perdanan') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-pink-100 hover:border-pink-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-pink-500 to-pink-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📄</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Billing Perdanan</h2>
                                <p class="text-pink-100">Invoice Management</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Manage billing and invoice processing for Perdanan</p>
                        <div class="flex items-center text-pink-600 font-semibold">
                            <span>Open Billing Perdanan</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            
            <a href="{{ route('collection.collection-ratio') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-indigo-100 hover:border-indigo-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">📈</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Collection Ratio</h2>
                                <p class="text-indigo-100">Performance Metrics</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">View and analyze collection ratio performance</p>
                        <div class="flex items-center text-indigo-600 font-semibold">
                            <span>Open Collection Ratio</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            
            <a href="{{ route('collection.utip') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-violet-100 hover:border-violet-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-violet-500 to-violet-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">💳</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">UTIP</h2>
                                <p class="text-violet-100">Payment Processing</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Manage UTIP payment systems and processes</p>
                        <div class="flex items-center text-violet-600 font-semibold">
                            <span>Open UTIP</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
