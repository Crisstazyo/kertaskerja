@extends('layouts.app')

@section('title', 'Combat the Churn - CTC')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">🎯 Combat the Churn</h1>
                    <p class="text-gray-600 text-lg">Churn Prevention Management - SSL Tracking</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('ctc.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        ← Back to Dashboard
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                            🚪 Logout
                        </button>
                    </form>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- Menu Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- CT0 Card -->
            <a href="{{ route('ctc.combat-churn-ct0') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                                    <span class="text-4xl">📊</span>
                                </div>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">CT0</h2>
                            <p class="text-blue-100">Customer Touch Zero</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Manage CT0 commitment and realization (SSL)</p>
                        <div class="flex items-center text-blue-600 font-semibold group-hover:text-blue-700">
                            <span>Open CT0</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Sales HSI Card -->
            <a href="{{ route('ctc.combat-churn-sales-hsi') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                                    <span class="text-4xl">💼</span>
                                </div>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">Sales HSI (all)</h2>
                            <p class="text-purple-100">High Speed Internet Sales</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Track Sales HSI commitment and realization</p>
                        <div class="flex items-center text-purple-600 font-semibold group-hover:text-purple-700">
                            <span>Open Sales HSI</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Churn Card -->
            <a href="{{ route('ctc.combat-churn-churn') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-red-500 to-red-600 p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                                    <span class="text-4xl">⚠️</span>
                                </div>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">Churn</h2>
                            <p class="text-red-100">Customer Churn Prevention</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Monitor churn prevention initiatives</p>
                        <div class="flex items-center text-red-600 font-semibold group-hover:text-red-700">
                            <span>Open Churn</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Winback Card -->
            <a href="{{ route('ctc.combat-churn-winback') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-16 translate-x-16"></div>
                        <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full translate-y-12 -translate-x-12"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-4">
                                <div class="bg-white/20 p-4 rounded-lg backdrop-blur-sm">
                                    <span class="text-4xl">🔄</span>
                                </div>
                                <svg class="w-6 h-6 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">Winback</h2>
                            <p class="text-green-100">Customer Winback Strategy</p>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Track customer winback campaigns</p>
                        <div class="flex items-center text-green-600 font-semibold group-hover:text-green-700">
                            <span>Open Winback</span>
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
