@extends('layouts.app')

@section('title', 'Collection Dashboard')

@section('content')
<div class="flex min-h-screen bg-gray-50">
    <div class="w-64 bg-slate-900 shadow-xl hidden md:block">
        <div class="p-6">
            <h1 class="text-white text-xl font-bold italic">COLLECTION <span class="text-indigo-400">SYS</span></h1>
        </div>
        <nav class="mt-6 px-4 space-y-2">
            <p class="text-gray-400 text-xs uppercase font-semibold px-2 mb-2">Main Menu</p>
            <a href="{{ route('collection.c3mr') }}" class="flex items-center text-gray-300 hover:bg-slate-800 hover:text-white px-4 py-3 rounded-lg transition">
                <span class="mr-3">📊</span> C3MR
            </a>
            <a href="{{ route('collection.billing') }}" class="flex items-center text-gray-300 hover:bg-slate-800 hover:text-white px-4 py-3 rounded-lg transition">
                <span class="mr-3">📄</span> Billing Perdanan
            </a>
            <a href="{{ route('collection.cr') }}" class="flex items-center text-gray-300 hover:bg-slate-800 hover:text-white px-4 py-3 rounded-lg transition">
                <span class="mr-3">📈</span> Collection Ratio
            </a>
            <a href="{{ route('collection.utip') }}" class="flex items-center text-gray-300 hover:bg-slate-800 hover:text-white px-4 py-3 rounded-lg transition">
                <span class="mr-3">💳</span> UTIP
            </a>
        </nav>
    </div>

    <div class="flex-1">
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">💰 Collection Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back, Admin</p>
            </div>
            
            <div class="flex items-center gap-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-gray-600 hover:text-red-600 font-medium transition">
                        <span class="mr-2">🚪</span> Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="p-8">
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Akses Cepat Kertas Kerja</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <a href="{{ route('collection.c3mr') }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-indigo-400 transition group">
                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-100 text-2xl rounded-lg group-hover:bg-indigo-600 transition duration-300">📊</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">C3MR</h4>
                            <p class="text-xs text-gray-500">Customer Credit Management Reporting</p>
                        </div>
                        <svg class="w-5 h-5 ml-auto text-gray-300 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('collection.billing') }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-pink-400 transition group">
                        <div class="w-12 h-12 flex items-center justify-center bg-pink-100 text-2xl rounded-lg group-hover:bg-pink-600 transition duration-300">📄</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Billing Perdanan</h4>
                            <p class="text-xs text-gray-500">Invoice & Billing Management</p>
                        </div>
                        <svg class="w-5 h-5 ml-auto text-gray-300 group-hover:text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('collection.cr') }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-blue-400 transition group">
                        <div class="w-12 h-12 flex items-center justify-center bg-blue-100 text-2xl rounded-lg group-hover:bg-blue-600 transition duration-300">📈</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">Collection Ratio</h4>
                            <p class="text-xs text-gray-500">Analyze Performance Metrics</p>
                        </div>
                        <svg class="w-5 h-5 ml-auto text-gray-300 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <a href="{{ route('collection.utip') }}" class="flex items-center p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md hover:border-violet-400 transition group">
                        <div class="w-12 h-12 flex items-center justify-center bg-violet-100 text-2xl rounded-lg group-hover:bg-violet-600 transition duration-300">💳</div>
                        <div class="ml-4">
                            <h4 class="font-bold text-gray-800">UTIP</h4>
                            <p class="text-xs text-gray-500">Payment Processing System</p>
                        </div>
                        <svg class="w-5 h-5 ml-auto text-gray-300 group-hover:text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-4 flex items-center text-indigo-800 text-sm">
                <span class="mr-3 text-xl">💡</span>
                Pilih salah satu menu di atas untuk mulai menginput data atau menarik laporan harian.
            </div>
        </main>
    </div>
</div>
@endsection