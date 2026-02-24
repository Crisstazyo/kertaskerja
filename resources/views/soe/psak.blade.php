@extends('layouts.app')

@section('title', 'SOE - PSAK')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-pink-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('soe.dashboard') }}" class="text-purple-600 hover:text-purple-800 mb-2 inline-block">← Back to Dashboard</a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📋 PSAK</h1>
                    <p class="text-gray-600 text-lg">Coming Soon</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 via-pink-500 to-red-500 rounded-full"></div>
        </div>

        <!-- Coming Soon Card -->
        <div class="bg-white rounded-xl shadow-lg p-16 text-center">
            <div class="text-8xl mb-6">🚧</div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Coming Soon</h2>
            <p class="text-gray-600 text-lg">PSAK feature is under development</p>
        </div>
    </div>
</div>
@endsection
