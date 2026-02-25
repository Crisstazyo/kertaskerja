@extends('layouts.app')

@section('title', 'Pilih Tipe - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-blue-50 to-pink-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm mb-2 inline-block font-medium">
                        ← Kembali ke Admin Panel
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ ucfirst($role) }}
                    </h1>
                    <p class="text-gray-600 mt-1">Pilih tipe worksheet yang ingin dikelola</p>
                </div>
            </div>
        </div>

        <!-- Type Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Scalling Card -->
            <a href="{{ route('admin.select-type', [$role, 'scalling']) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-blue-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-blue-600 p-8 text-white">
                    <h2 class="text-2xl font-semibold mb-2">Scalling</h2>
                    <p class="text-blue-100">Kelola worksheet Scalling dengan kategori LOP</p>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Kategori LOP:</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• LOP On Hand</li>
                            <li>• LOP Qualified</li>
                            @if($role !== 'government')
                            <li>• LOP Initiate</li>
                            @endif
                            <li>• LOP Koreksi</li>
                        </ul>
                    </div>
                    <div class="text-blue-600 font-medium">
                        Pilih Kategori LOP
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <a href="{{ route('admin.select-type', [$role, 'psak']) }}" class="bg-white rounded-lg shadow-sm border border-gray-200 hover:border-green-500 hover:shadow-md transition-all overflow-hidden">
                <div class="bg-green-600 p-8 text-white">
                    <h2 class="text-2xl font-semibold mb-2">PSAK</h2>
                    <p class="text-green-100">Kelola worksheet PSAK</p>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <h3 class="font-semibold text-gray-700 mb-2">Fitur:</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Tambah tabel worksheet</li>
                            <li>• Lihat data worksheet</li>
                            <li>• Lihat riwayat worksheet</li>
                        </ul>
                    </div>
                    <div class="text-green-600 font-medium">
                        Kelola PSAK
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
