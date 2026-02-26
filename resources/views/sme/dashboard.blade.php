@extends('layouts.app')

@section('title', 'SME Dashboard')

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
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">SME Dashboard</h1>
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
            <a href="{{ route('sme.scalling') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-indigo-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">Scalling</h2>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
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
            <a href="{{ route('sme.psak') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-fuchsia-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-purple-500 to-fuchsia-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">PSAK</h2>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-purple-600 font-bold group-hover:text-purple-700 transition-colors">
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

            
        </div>
    </div>
</div>
@endsection
