@extends('layouts.app')

@section('title', 'Admin - LOP On Hand History')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.lop-on-hand') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">← Back to LOP On Hand</a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">LOP On Hand History</h1>
                    <p class="text-gray-600">All Import Records</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md font-medium transition-colors">
                        Logout
                    </button>
                </form>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 via-blue-500 to-indigo-500 rounded-full"></div>
        </div>

        <!-- History Timeline -->
        <div class="space-y-6">
            @forelse($imports as $import)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:border-purple-500 transition-all">
                <div class="bg-purple-600 p-6 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold">{{ $import->file_name }}</h3>
                            <p class="text-sm text-purple-100 mt-1">
                                Uploaded by <span class="font-medium">{{ $import->uploaded_by }}</span> 
                                on {{ $import->created_at->format('d M Y H:i') }}
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-20 px-6 py-3 rounded-md">
                            <p class="text-xs font-medium">Total Rows</p>
                            <p class="text-2xl font-semibold">{{ $import->data_count }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-md p-4 border border-blue-200">
                            <p class="text-sm text-gray-600">Import ID</p>
                            <p class="text-lg font-semibold text-gray-900">#{{ $import->id }}</p>
                        </div>
                        <div class="bg-green-50 rounded-md p-4 border border-green-200">
                            <p class="text-sm text-gray-600">Date</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $import->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="bg-purple-50 rounded-md p-4 border border-purple-200">
                            <p class="text-sm text-gray-600">Time</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $import->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No History Yet</h3>
                <p class="text-gray-600">No import records found</p>
                <a href="{{ route('admin.lop-on-hand') }}" class="mt-6 inline-block bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                    Upload First File
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
