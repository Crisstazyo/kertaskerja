@extends('layouts.app')

@section('title', 'PSAK - ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-full mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">PSAK - {{ ucfirst($role) }}</h1>
                    <p class="text-gray-600">Kertas Kerja PSAK</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        ← Kembali ke Menu
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        <!-- PSAK Content -->
        <div class="bg-white rounded-lg shadow-md p-12">
            <div class="text-center py-16">
                <svg class="w-32 h-32 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-3xl font-bold text-gray-600 mb-4">Halaman PSAK</h3>
                <p class="text-gray-500 text-lg">Tampilan PSAK sedang dalam pengembangan</p>
                <p class="text-gray-400 mt-2">Fitur ini akan segera tersedia</p>
            </div>
        </div>
    </div>
</div>
@endsection
