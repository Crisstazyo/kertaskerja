@extends('layouts.app')

@section('title', 'Admin - CTC Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-cyan-600 hover:text-cyan-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke Admin Dashboard
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-1">📊 CTC Management</h1>
                    <p class="text-gray-600">Admin mengelola seluruh data Combat The Churn semua user</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- Feature Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <!-- Paid CT0 -->
            <a href="{{ route('admin.ctc.paid-ct0') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-cyan-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-cyan-500 to-cyan-600 p-6 text-white">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Paid CT0</h2>
                            <p class="text-cyan-100">Payment Tracking & Management</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Kelola dan monitor data Paid CT0 semua user</p>
                    <div class="flex items-center text-cyan-600 font-semibold">
                        Kelola Paid CT0
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Combat The Churn -->
            <a href="{{ route('admin.ctc.combat-churn') }}" class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-xl">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold">Combat The Churn</h2>
                            <p class="text-blue-100">Churn Analysis & Management</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-3">Kelola dan monitor data Combat The Churn semua user</p>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">CT0</span>
                        <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-2 py-1 rounded-full">Sales HSI</span>
                        <span class="bg-purple-100 text-purple-700 text-xs font-semibold px-2 py-1 rounded-full">Churn</span>
                        <span class="bg-cyan-100 text-cyan-700 text-xs font-semibold px-2 py-1 rounded-full">Winback</span>
                    </div>
                    <div class="flex items-center text-blue-600 font-semibold">
                        Kelola Combat The Churn
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
