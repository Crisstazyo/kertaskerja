@extends('layouts.app')

@section('title', 'Kertas Kerja - Beranda')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="text-center">
        <!-- Logo Telkom -->
        <div class="mb-8 flex justify-center">
            <img src="{{ asset('img/Telkom.png') }}" alt="Logo Telkom" class="h-32 w-auto">
        </div>
        
        <!-- Title -->
        <h1 class="text-5xl font-bold text-gray-800 mb-4">Kertas Kerja</h1>
        <p class="text-xl text-gray-600 mb-12">Sistem Manajemen Dokumen Kerja</p>
        
        <!-- Button to Role Selection -->
        <a href="{{ route('roles') }}" class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-4 px-8 rounded-lg shadow-lg transition duration-300 transform hover:scale-105">
            Mulai
        </a>
    </div>
</div>
@endsection
