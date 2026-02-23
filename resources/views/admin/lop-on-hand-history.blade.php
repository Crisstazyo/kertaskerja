@extends('layouts.app')

@section('title', 'Admin - LOP On Hand History')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.lop-on-hand') }}" class="text-purple-600 hover:text-purple-800 mb-2 inline-block">← Back to LOP On Hand</a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📜 LOP On Hand History</h1>
                    <p class="text-gray-600 text-lg">All Import Records</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                        🚪 Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 via-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- History Timeline -->
        <div class="space-y-6">
            @forelse($imports as $import)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-gray-100 hover:border-purple-300 transition-all duration-300">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-3xl">📄</span>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold">{{ $import->file_name }}</h3>
                                <p class="text-sm text-purple-100 mt-1">
                                    Uploaded by <span class="font-semibold">{{ $import->uploaded_by }}</span> 
                                    on {{ $import->created_at->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="bg-white bg-opacity-20 px-6 py-3 rounded-lg inline-block">
                                <p class="text-sm font-semibold">Total Rows</p>
                                <p class="text-3xl font-bold">{{ $import->data_count }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">📊</span>
                                <div>
                                    <p class="text-sm text-gray-600">Import ID</p>
                                    <p class="text-lg font-bold text-gray-900">#{{ $import->id }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">📅</span>
                                <div>
                                    <p class="text-sm text-gray-600">Date</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $import->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <div class="flex items-center space-x-3">
                                <span class="text-2xl">⏰</span>
                                <div>
                                    <p class="text-sm text-gray-600">Time</p>
                                    <p class="text-lg font-bold text-gray-900">{{ $import->created_at->format('H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📜</div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">No History Yet</h3>
                <p class="text-gray-600">No import records found</p>
                <a href="{{ route('admin.lop-on-hand') }}" class="mt-6 inline-block bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300">
                    Upload First File
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
