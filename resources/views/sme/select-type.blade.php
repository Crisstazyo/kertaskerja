@extends('layouts.app')

@section('title', 'Pilih Type - SME')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="text-6xl mb-4">🏛️</div>
            <h1 class="text-4xl font-bold text-gray-800 mb-2">SME Panel</h1>
            <p class="text-gray-600">Pilih jenis worksheet yang ingin Anda kelola</p>
        </div>

        <!-- Selection Cards -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Scalling Card -->
            <a href="{{ route('sme.select-lop', 'scalling') }}" 
               class="group bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-blue-500">
                <div class="text-center">
                    <div class="text-7xl mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        📊
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 group-hover:text-blue-600 transition-colors">
                        Scalling
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Sistem scalling dengan kategorisasi LOP (Low, Medium, High) untuk analisis mendalam
                    </p>
                    <div class="flex items-center justify-center space-x-2 text-blue-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Pilih Scalling</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- PSAK Card -->
            <a href="{{ route('sme.select-lop', 'psak') }}" 
               class="group bg-white rounded-2xl shadow-lg p-8 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border-2 border-transparent hover:border-purple-500">
                <div class="text-center">
                    <div class="text-7xl mb-6 transform group-hover:scale-110 transition-transform duration-300">
                        📋
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 group-hover:text-purple-600 transition-colors">
                        PSAK
                    </h2>
                    <p class="text-gray-600 mb-6">
                        Pengelolaan worksheet berdasarkan standar PSAK dengan fitur kategorisasi lengkap
                    </p>
                    <div class="flex items-center justify-center space-x-2 text-purple-600 font-semibold group-hover:translate-x-2 transition-transform">
                        <span>Pilih PSAK</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-12">
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg transition duration-300">
                    ← Logout
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
