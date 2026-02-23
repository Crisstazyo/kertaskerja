@extends('layouts.app')

@section('title', 'LOP Qualified History - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.lop.qualified', $entity) }}" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">📜 LOP Qualified History</h1>
                        <p class="text-gray-600">{{ ucfirst($entity) }} - Riwayat Import</p>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full"></div>
        </div>

        @if($imports->count() > 0)
        <div class="grid gap-4">
            @foreach($imports as $import)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-300 transition-all duration-300">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">📄 {{ $import->file_name }}</h3>
                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <p class="text-xs text-gray-500">Uploaded By</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $import->uploaded_by }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Total Rows</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $import->data_count }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Uploaded At</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ $import->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Entity</p>
                                    <p class="text-sm font-semibold text-gray-700">{{ ucfirst($import->entity_type) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-gray-100">
            <span class="text-6xl mb-4 block">📭</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada History</h3>
            <p class="text-gray-600">Belum ada data yang pernah diimport</p>
        </div>
        @endif
    </div>
</div>
@endsection
