@extends('layouts.app')

@section('title', 'CTC Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-cyan-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📊 CTC Dashboard</h1>
                    <p class="text-gray-600 text-lg">Combat the Churn Management System</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-cyan-500 via-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- Menu Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Paid CT0 Card -->
            <a href="{{ route('ctc.paid-ct0') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-cyan-100 hover:border-cyan-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">💰</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Paid CT0</h2>
                                <p class="text-cyan-100">Payment Management</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Manage and track paid CT0 data</p>
                        <div class="flex items-center text-cyan-600 font-semibold">
                            <span>Open Paid CT0</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>

            <!-- Combat the Churn Card -->
            <a href="{{ route('ctc.combat-the-churn') }}" class="group">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                                <span class="text-5xl">🎯</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Combat the Churn</h2>
                                <p class="text-blue-100">Churn Prevention</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">Track and manage churn prevention strategies</p>
                        <div class="flex items-center text-blue-600 font-semibold">
                            <span>Open Combat the Churn</span>
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Welcome Message -->
        <div class="mt-8 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-3">Welcome, {{ Auth::user()->name }}!</h3>
            <p class="text-gray-600">Select a menu above to access CTC features and manage your data.</p>
        </div>
    </div>
</div>
@endsection
