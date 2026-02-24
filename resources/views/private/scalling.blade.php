@extends('layouts.app')

@section('title', 'Private - Scalling')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full filter blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-indigo-100 to-indigo-50 rounded-full filter blur-3xl opacity-40 translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('private.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Dashboard
                        </a>
                        <div class="border-l-2 border-gray-300 h-12"></div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Scalling Management</h1>
                            <p class="text-gray-500 text-sm font-medium">LOP Data Categories</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOP Categories Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- LOP On Hand Card -->
            <a href="{{ route('private.lop-on-hand') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative flex items-start justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                            </div>
                            <h2 class="text-2xl font-bold mb-2">LOP On Hand</h2>
                            <p class="text-emerald-100 text-sm font-medium">Data Visualization & Tracking</p>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-gray-600 mb-6 leading-relaxed">Access and manage LOP On Hand data with advanced filtering and real-time funnel tracking</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-emerald-600 font-bold group-hover:text-emerald-700 transition-colors">
                                    <span>Open Data</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Qualified Card -->
            <a href="{{ route('private.lop-qualified') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-fuchsia-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-purple-500 to-fuchsia-600 p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative flex items-start justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                            </div>
                            <h2 class="text-2xl font-bold mb-2">LOP Qualified</h2>
                            <p class="text-purple-100 text-sm font-medium">Qualified Data Management</p>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-gray-600 mb-6 leading-relaxed">Manage qualified LOP data with comprehensive tracking and analytics capabilities</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-purple-600 font-bold group-hover:text-purple-700 transition-colors">
                                    <span>Open Data</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Koreksi Card -->
            <a href="{{ route('private.lop-koreksi') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-rose-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
                    
                    <div class="relative">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative flex items-start justify-between mb-4">
                                <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-lg group-hover:scale-110 transition-transform duration-500">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </div>
                                <span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                            </div>
                            <h2 class="text-2xl font-bold mb-2">LOP Koreksi</h2>
                            <p class="text-pink-100 text-sm font-medium">Correction & Amendment Data</p>
                        </div>
                        
                        <div class="p-6">
                            <p class="text-gray-600 mb-6 leading-relaxed">Handle correction and amendment data with detailed tracking and validation</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-pink-600 font-bold group-hover:text-pink-700 transition-colors">
                                    <span>Open Data</span>
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
