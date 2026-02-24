@extends('layouts.app')

@section('title', 'Kertas Kerja Management System')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-gray-50">
    <!-- Premium Navbar -->
    <nav class="bg-white/80 backdrop-blur-xl shadow-xl border-b-2 border-red-600 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-12 w-auto">
                    <div class="border-l-2 border-gray-300 h-12"></div>
                    <div>
                        <div class="text-xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Kertas Kerja</div>
                        <div class="text-xs text-gray-500 font-semibold">Management System</div>
                    </div>
                </div>
                <div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="group px-6 py-3 text-gray-600 hover:text-gray-800 font-semibold transition-all duration-300 rounded-lg hover:bg-gray-100">
                                <span class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    <span>Logout</span>
                                </span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.show') }}" 
                           class="px-8 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-xl hover:shadow-2xl inline-flex items-center space-x-2">
                            <span>Sign In</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Enhanced Design -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
        <!-- Decorative Background Elements -->
        <div class="absolute top-20 left-0 w-96 h-96 bg-gradient-to-br from-red-100 to-red-50 rounded-full filter blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-blue-100 to-blue-50 rounded-full filter blur-3xl opacity-30"></div>
        
        <!-- Main Hero -->
        <div class="relative text-center mb-20">
            <div class="inline-block mb-8 animate-pulse">
                <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-8 py-3 rounded-full text-sm font-bold shadow-2xl border-2 border-red-500">
                    <span class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                        </svg>
                        <span>Enterprise-Grade Platform</span>
                    </span>
                </div>
            </div>
            <h1 class="text-7xl font-black text-gray-900 mb-6 leading-tight">
                Sistem Manajemen<br/>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-700 to-red-800 drop-shadow-lg">
                    Kertas Kerja Profesional
                </span>
            </h1>
            <p class="text-2xl text-gray-600 mb-12 max-w-4xl mx-auto leading-relaxed font-medium">
                Platform digital terintegrasi untuk pengelolaan worksheet PSAK dan Scalling dengan fitur lengkap, 
                interface modern, dan sistem terstruktur untuk meningkatkan efisiensi kerja Anda
            </p>
            <div class="flex justify-center gap-6">
                <a href="{{ route('login.show') }}" 
                   class="group relative px-12 py-5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl transition-all duration-300 transform hover:scale-105 shadow-2xl hover:shadow-red-500/50 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-red-700 to-red-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <span class="relative flex items-center space-x-3 text-lg">
                        <span>Get Started Now</span>
                        <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </span>
                </a>
                <a href="#features" 
                   class="px-12 py-5 bg-white hover:bg-gray-50 text-gray-800 font-bold rounded-xl transition-all duration-300 border-2 border-gray-300 hover:border-red-600 shadow-xl hover:shadow-2xl transform hover:scale-105 text-lg">
                    Learn More
                </a>
            </div>
        </div>

        <!-- Premium Features Grid -->
        <div id="features" class="relative grid md:grid-cols-3 gap-10 mb-20">
            <!-- Feature 1 -->
            <div class="group relative bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200/50 p-10 hover:shadow-red-500/20 transition-all duration-500 transform hover:-translate-y-3 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100 to-emerald-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-8 shadow-2xl group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Government Panel</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Akses khusus untuk pengelolaan data pemerintah dengan sistem keamanan tingkat tinggi dan fitur kolaborasi terintegrasi
                    </p>
                </div>
            </div>

            <!-- Feature 2 -->
            <div class="group relative bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200/50 p-10 hover:shadow-blue-500/20 transition-all duration-500 transform hover:-translate-y-3 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-blue-500 to-indigo-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-8 shadow-2xl group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Admin Control</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Panel administrasi lengkap untuk mengelola seluruh sistem, user management, dan monitoring aktivitas real-time
                    </p>
                </div>
            </div>

            <!-- Feature 3 -->
            <div class="group relative bg-white/80 backdrop-blur-lg rounded-2xl shadow-2xl border border-gray-200/50 p-10 hover:shadow-purple-500/20 transition-all duration-500 transform hover:-translate-y-3 overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100 to-purple-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-600 w-20 h-20 rounded-2xl flex items-center justify-center mb-8 shadow-2xl group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-800 mb-4">Smart Analytics</h3>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Kelola worksheet PSAK dan Scalling dengan sistem kategorisasi otomatis dan analisis data mendalam
                    </p>
                </div>
            </div>
        </div>

        <!-- Premium Info Sections -->
        <div class="grid md:grid-cols-2 gap-10 mb-20">
            <div class="group relative bg-gradient-to-br from-red-600 via-red-700 to-red-800 rounded-3xl shadow-2xl p-12 text-white overflow-hidden hover:shadow-red-500/50 transition-all duration-500 transform hover:scale-[1.02]">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-red-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-2xl group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-black">PSAK Management</h3>
                    </div>
                    <p class="text-red-50 text-xl leading-relaxed font-medium">
                        Sistem pengelolaan worksheet berdasarkan standar PSAK dengan fitur kategorisasi lengkap, 
                        validasi otomatis, dan reporting terintegrasi untuk memastikan compliance yang optimal
                    </p>
                </div>
            </div>

            <div class="group relative bg-gradient-to-br from-purple-600 via-purple-700 to-purple-800 rounded-3xl shadow-2xl p-12 text-white overflow-hidden hover:shadow-purple-500/50 transition-all duration-500 transform hover:scale-[1.02]">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-4 mb-8">
                        <div class="bg-white/20 backdrop-blur-sm p-4 rounded-2xl shadow-2xl group-hover:scale-110 transition-transform duration-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-4xl font-black">Scalling System</h3>
                    </div>
                    <p class="text-purple-50 text-xl leading-relaxed font-medium">
                        Platform scalling dengan kategori LOP (Low, Medium, High) untuk analisis yang lebih detail, 
                        tracking progress real-time, dan dashboard visual yang memudahkan pengambilan keputusan
                    </p>
                </div>
            </div>
        </div>

        <!-- Premium Stats Section -->
        <div class="relative bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl p-14 border-2 border-red-600 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-red-100 to-red-50 rounded-full -translate-y-1/2 translate-x-1/2 opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tl from-blue-100 to-blue-50 rounded-full translate-y-1/2 -translate-x-1/2 opacity-50"></div>
            
            <div class="relative text-center mb-12">
                <h2 class="text-4xl font-black text-gray-800 mb-4">Why Choose Our Platform?</h2>
                <p class="text-gray-600 text-xl font-medium">Solusi terpercaya untuk manajemen kertas kerja enterprise</p>
            </div>
            <div class="relative grid md:grid-cols-4 gap-10">
                <div class="text-center group">
                    <div class="mb-4 inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="text-5xl font-black text-red-600 mb-3">100%</div>
                    <div class="text-gray-700 font-bold text-lg">Secure & Reliable</div>
                </div>
                <div class="text-center group">
                    <div class="mb-4 inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="text-5xl font-black text-emerald-600 mb-3">24/7</div>
                    <div class="text-gray-700 font-bold text-lg">System Availability</div>
                </div>
                <div class="text-center group">
                    <div class="mb-4 inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="text-5xl font-black text-blue-600 mb-3">Fast</div>
                    <div class="text-gray-700 font-bold text-lg">Performance</div>
                </div>
                <div class="text-center group">
                    <div class="mb-4 inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                    </div>
                    <div class="text-5xl font-black text-purple-600 mb-3">Easy</div>
                    <div class="text-gray-700 font-bold text-lg">To Use</div>
                </div>
            </div>
        </div>
<!-- Premium Footer -->
    <footer class="bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white py-16 mt-32 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-red-900/20 to-transparent rounded-full -translate-y-1/2 -translate-x-1/2"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-blue-900/20 to-transparent rounded-full translate-y-1/2 translate-x-1/2"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="mb-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-12 w-auto brightness-0 invert mb-4">
                        <div class="w-24 h-1 bg-gradient-to-r from-red-600 to-red-700 rounded-full"></div>
                    </div>
                    <p class="text-gray-400 text-base leading-relaxed font-medium">
                        Platform manajemen kertas kerja terintegrasi untuk meningkatkan efisiensi dan produktivitas kerja Anda dengan teknologi enterprise-grade.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-xl text-white">Quick Links</h4>
                    <ul class="space-y-4">
                        <li>
                            <a href="#" class="group flex items-center text-gray-400 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                About
                            </a>
                        </li>
                        <li>
                            <a href="#features" class="group flex items-center text-gray-400 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Features
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('login.show') }}" class="group flex items-center text-gray-400 hover:text-white transition-all duration-300">
                                <svg class="w-4 h-4 mr-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                                Login
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-6 text-xl text-white">Contact</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start text-gray-400">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span>info@telkom.co.id</span>
                        </li>
                        <li class="flex items-start text-gray-400">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span>+62 xxx xxxx</span>
                        </li>
                        <li class="flex items-start text-gray-400">
                            <svg class="w-5 h-5 mr-3 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Support: 24/7 Available</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-10 text-center">
                <p class="text-gray-400 text-base">
                    &copy; {{ date('Y') }} <span class="font-bold text-white">PT Telkom Indonesia</span>. All rights reserved. | 
                    <span class="text-red-500 font-semibold">Kertas Kerja Management System</span> v1.0
                </p>
            </div>
        </div>
    </footer>
</div>
@endsection
