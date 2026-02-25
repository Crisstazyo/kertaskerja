@extends('layouts.app')

@section('title', 'Pilih LOP - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('admin.select-role', $role) }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block font-medium">
                        ← Kembali ke Pilih Tipe
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ ucfirst($role) }} - Scalling
                    </h1>
                    <p class="text-gray-600 mt-1">Pilih kategori LOP yang ingin dikelola</p>
                </div>
            </div>
        </div>

        <!-- LOP Category Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- LOP On Hand -->
            <a href="{{ route('admin.lop.on_hand', $role) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-emerald-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-emerald-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">LOP On Hand</h2>
                    <p class="text-emerald-100 text-sm">F5 - On Hand</p>
                </div>
                <div class="p-4">
                    <span class="text-emerald-600 font-medium text-sm">Kelola</span>
                </div>
            </a>

            <!-- LOP Qualified -->
            <a href="{{ route('admin.lop.qualified', $role) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-green-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-green-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">LOP Qualified</h2>
                    <p class="text-green-100 text-sm">F3-F4 - Qualified</p>
                </div>
                <div class="p-4">
                    <span class="text-green-600 font-medium text-sm">Kelola</span>
                </div>
            </a>

            <!-- LOP Initiate -->
            <a href="{{ route('admin.lop.initiate', $role) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-purple-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-purple-600 p-6 text-white">
                    <h2 class="text-xl font-semibold mb-1">LOP Initiate</h2>
                    <p class="text-purple-100 text-sm">F0-F2 - Initiate</p>
                </div>
                <div class="p-4">
                    <span class="text-purple-600 font-medium text-sm">Kelola</span>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
