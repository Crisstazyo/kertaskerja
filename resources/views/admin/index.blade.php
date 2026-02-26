@extends('layouts.app')

@section('title', 'Admin Dashboard - Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Admin Dashboard</h1>
                    <p class="text-gray-600 text-lg">Kertas Kerja Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-lg font-medium transition-all shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-full"></div>
        </div>

        <!-- Main Content -->
        <!-- Main Content -->
        
        <!-- 1. SCALING SECTION -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-orange-500 to-red-500 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Scaling Management</h2>
                    <p class="text-gray-600">Project Management by Segment</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Government Scaling -->
                <a href="{{ route('admin.scalling', 'government') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                            </div>
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">GOV</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Government</h3>
                        <p class="text-gray-600 text-sm mb-4">Pemerintah Scaling Project</p>
                        <div class="flex items-center text-green-600 font-medium">
                            <span class="text-sm">Manage Data</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Private Scaling -->
                <a href="{{ route('admin.scalling', 'private') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">PVT</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Private</h3>
                        <p class="text-gray-600 text-sm mb-4">Swasta Scaling Project</p>
                        <div class="flex items-center text-blue-600 font-medium">
                            <span class="text-sm">Manage Data</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- SOE Scaling -->
                <a href="{{ route('admin.scalling', 'soe') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-purple-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                                </svg>
                            </div>
                            <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-3 py-1 rounded-full">SOE</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">SOE</h3>
                        <p class="text-gray-600 text-sm mb-4">BUMN Scaling Project</p>
                        <div class="flex items-center text-purple-600 font-medium">
                            <span class="text-sm">Manage Data</span>
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- SME Scaling -->
                <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 7H7v6h6V7z"/>
                                    <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span class="bg-orange-100 text-orange-700 text-xs font-semibold px-3 py-1 rounded-full">SME</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">SME</h3>
                        <p class="text-gray-600 text-sm mb-4">UKM Scaling Project</p>
                        <div class="space-y-2 mt-4">
                            <a href="{{ route('admin.scalling', 'sme') }}" class="block w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-md hover:shadow-lg">
                                <span class="flex items-center justify-between">
                                    <span class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Manage General Data</span>
                                    </span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </a>
                            <a href="{{ route('admin.scalling.hsi-agency') }}" class="block w-full bg-orange-50 hover:bg-orange-100 text-orange-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <span class="flex items-center justify-between">
                                    HSI Agency
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </a>
                            <a href="{{ route('admin.scalling.telda') }}" class="block w-full bg-orange-50 hover:bg-orange-100 text-orange-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <span class="flex items-center justify-between">
                                    Telda
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. COLLECTION SECTION -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-pink-500 to-rose-500 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Collection Management</h2>
                    <p class="text-gray-600">Monitor Collection Activities</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- C3MR -->
                <a href="{{ route('admin.collection.c3mr') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pink-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-400 to-pink-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-pink-500 to-pink-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">C3MR</h3>
                        <p class="text-gray-600 text-sm mb-3">Collection Management</p>
                        <div class="flex items-center text-pink-600 font-medium text-sm">
                            View Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Billing Perdana -->
                <a href="{{ route('admin.collection.billing') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-rose-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-rose-400 to-rose-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-rose-500 to-rose-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Billing Perdana</h3>
                        <p class="text-gray-600 text-sm mb-3">Billing Management</p>
                        <div class="flex items-center text-rose-600 font-medium text-sm">
                            View Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Collection Ratio -->
                <a href="{{ route('admin.collection.collection-ratio') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-fuchsia-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-fuchsia-400 to-fuchsia-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-fuchsia-500 to-fuchsia-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Collection Ratio</h3>
                        <p class="text-gray-600 text-sm mb-3">CR Tracking</p>
                        <div class="flex items-center text-fuchsia-600 font-medium text-sm">
                            View Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- UTIP -->
                <a href="{{ route('admin.collection.utip') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-pink-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-pink-400 to-pink-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-pink-600 to-pink-700 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">UTIP</h3>
                        <p class="text-gray-600 text-sm mb-3">UTIP Management</p>
                        <div class="flex items-center text-pink-600 font-medium text-sm">
                            View Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- 3. COMBAT THE CHURN SECTION -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-500 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Combat The Churn</h2>
                    <p class="text-gray-600">CTC Management & Monitoring</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Paid CT0 -->
                <a href="{{ route('admin.ctc.paid-ct0') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-cyan-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-cyan-400 to-cyan-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-8 relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 p-4 rounded-xl shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Paid CT0</h3>
                        <p class="text-gray-600 mb-4">Payment Tracking & Management</p>
                        <div class="flex items-center text-cyan-600 font-semibold">
                            Track Payments
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Combat The Churn -->
                <a href="{{ route('admin.ctc.combat-churn') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-400 to-blue-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-8 relative z-10">
                        <div class="flex items-start justify-between mb-6">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Combat The Churn</h3>
                        <p class="text-gray-600 mb-4">Churn Analysis & Reports</p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            View Reports
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- 4. RISING STAR SECTION -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-yellow-500 to-amber-500 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Rising Star Program</h2>
                    <p class="text-gray-600">Performance Tracking by Level</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Bintang 1 -->
                <a href="{{ route('admin.rising-star.dashboard') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-yellow-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-300 to-yellow-500 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-yellow-400 to-yellow-500 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Bintang 1</h3>
                        <p class="text-gray-600 text-sm mb-3">Level 1 Program</p>
                        <div class="flex items-center text-yellow-600 font-medium text-sm">
                            Track Progress
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Bintang 2 -->
                <a href="{{ route('admin.rising-star.dashboard') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-yellow-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-yellow-400 to-yellow-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Bintang 2</h3>
                        <p class="text-gray-600 text-sm mb-3">Level 2 Program</p>
                        <div class="flex items-center text-yellow-600 font-medium text-sm">
                            Track Progress
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Bintang 3 -->
                <a href="{{ route('admin.rising-star.dashboard') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Bintang 3</h3>
                        <p class="text-gray-600 text-sm mb-3">Level 3 Program</p>
                        <div class="flex items-center text-orange-600 font-medium text-sm">
                            Track Progress
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Bintang 4 -->
                <a href="{{ route('admin.rising-star.dashboard') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-amber-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400 to-amber-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-amber-500 to-amber-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Bintang 4</h3>
                        <p class="text-gray-600 text-sm mb-3">Level 4 Program</p>
                        <div class="flex items-center text-amber-600 font-medium text-sm">
                            Track Progress
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- 5. PSAK SECTION -->
        <div class="mb-12">
            <div class="flex items-center mb-6">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-3 rounded-xl shadow-lg mr-4">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">PSAK Management</h2>
                    <p class="text-gray-600">Admin Input Commitment - User Input Real</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- PSAK Government -->
                <a href="{{ route('admin.psak', 'government') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400 to-green-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-green-500 to-green-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">PSAK Gov</h3>
                        <p class="text-gray-600 text-sm mb-3">Government PSAK</p>
                        <div class="flex items-center text-green-600 font-medium text-sm">
                            Manage Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- PSAK Private -->
                <a href="{{ route('admin.psak', 'private') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400 to-blue-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">PSAK Private</h3>
                        <p class="text-gray-600 text-sm mb-3">Private PSAK</p>
                        <div class="flex items-center text-blue-600 font-medium text-sm">
                            Manage Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- PSAK SOE -->
                <a href="{{ route('admin.psak', 'soe') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-purple-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400 to-purple-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">PSAK SOE</h3>
                        <p class="text-gray-600 text-sm mb-3">SOE PSAK</p>
                        <div class="flex items-center text-purple-600 font-medium text-sm">
                            Manage Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- PSAK SME -->
                <a href="{{ route('admin.psak', 'sme') }}" class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-orange-300 transform hover:-translate-y-2">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-400 to-orange-600 opacity-10 rounded-bl-full transform group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="p-6 relative z-10">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-3 rounded-xl shadow-lg mb-4 w-fit">
                            <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">PSAK SME</h3>
                        <p class="text-gray-600 text-sm mb-3">SME PSAK</p>
                        <div class="flex items-center text-orange-600 font-medium text-sm">
                            Manage Data
                            <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection