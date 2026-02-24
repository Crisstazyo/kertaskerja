@extends('layouts.app')

@section('title', 'Government Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-red-100 to-red-50 rounded-full filter blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-blue-100 to-blue-50 rounded-full filter blur-3xl opacity-40 translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Premium Header -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Telkom Logo" class="h-16 w-auto">
                        <div class="border-l-2 border-gray-300 h-16"></div>
                        <div>
                            <div class="flex items-center space-x-3 mb-1">
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Government Dashboard</h1>
                                <span class="px-3 py-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-xs font-semibold rounded-full shadow-lg">PREMIUM</span>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">Kertas Kerja Management System - Executive Portal</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group relative px-6 py-3 bg-gradient-to-r from-gray-800 to-gray-900 hover:from-gray-900 hover:to-black text-white rounded-xl font-semibold transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-600 to-red-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="relative flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                <span>Logout</span>
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Premium Data Management Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10">
            <!-- Scalling Card -->
            <a href="{{ route('gov.scalling') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative flex items-start justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                            </div>
                            <h2 class="text-2xl font-bold mb-2">Scalling</h2>
                            <p class="text-blue-100 text-sm font-medium">Advanced Analytics & Forms</p>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-gray-600 mb-6 leading-relaxed">Comprehensive scaling data management with interactive forms and analytics</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-blue-600 font-bold group-hover:text-blue-700 transition-colors">
                                    <span>Open Dashboard</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <div class="relative bg-white/60 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 opacity-60">
                <div class="relative">
                    <div class="bg-gradient-to-br from-purple-400 to-purple-500 p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                        <div class="relative flex items-start justify-between mb-4">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-lg">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">SOON</span>
                        </div>
                        <h2 class="text-2xl font-bold mb-2">PSAK</h2>
                        <p class="text-purple-100 text-sm font-medium">Coming Soon</p>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-gray-500 mb-6 leading-relaxed">PSAK management feature is currently under development</p>
                        <div class="flex items-center text-gray-400 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span>Not Available</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
