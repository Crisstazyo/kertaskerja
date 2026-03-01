@extends('layouts.app')

@section('title', 'Rising Star Dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 px-8 py-10">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-8 py-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 uppercase mb-2">Rising Star Dashboard</h1>
                    <p class="text-slate-500 font-semibold">Selamat datang, {{ Auth::user()->name }}</p>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-6 py-2 rounded-lg transition-all">Logout</button>
                </form>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-8 py-10">
            <p class="text-slate-600">Konten Rising Star Dashboard akan ditampilkan di sini.</p>
        </div>
    </div>
</div>
@endsection
