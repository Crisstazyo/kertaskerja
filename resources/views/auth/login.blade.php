@extends('layouts.app')

@section('title', 'Login - SOLID Dashboard')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row bg-slate-50">

    <div class="hidden md:flex md:w-1/2 lg:w-2/3 relative items-center justify-center p-12 overflow-hidden bg-white">

        <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&q=80"
             class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Bright Office">

        <div class="absolute inset-0 bg-gradient-to-tr from-white via-white/80 to-transparent z-10"></div>

        <div class="relative z-20 w-full max-w-2xl">
            <div class="flex items-center mb-12">
                <img src="{{ asset('img/Telkom.png') }}"
                     alt="Logo Telkom"
                     class="h-16 w-auto">

                <div class="h-14 w-px bg-slate-200 mx-8"></div>

                <div class="flex flex-col">
                    <span class="text-sm font-bold tracking-[0.3em] text-red-600 uppercase">Telkom Indonesia</span>
                    <span class="text-3xl font-light tracking-tight text-slate-800">Witel Sumut</span>
                </div>
            </div>

            <div class="space-y-4">
                <h1 class="text-6xl lg:text-7xl font-black tracking-tighter leading-tight text-slate-900">
                    Kertas Kerja <br>
                    <span class="text-red-600">Management System</span>
                </h1>

                <p class="text-xl text-slate-500 font-light max-w-md leading-relaxed">
                    Platform digital terintegrasi untuk pengelolaan worksheet Scalling dan PSAK dengan fitur lengkap dan sistem terstruktur untuk meningkatkan efisiensi kerja
                </p>
            </div>

            <div class="mt-10 w-24 h-2 bg-red-600 rounded-full"></div>
        </div>
    </div>

    <div class="w-full md:w-1/2 lg:w-1/3 flex items-center justify-center p-8 lg:p-16 bg-white z-20 border-l border-slate-100 shadow-2xl">
        <div class="w-full max-w-sm">
            <div class="mb-6">
                <h2 class="text-4xl font-black text-red-600 mb-2 tracking-tight">Login</h2>
                <p class="text-slate-500 font-medium text-base">Selamat datang di Kertas Kerja</p>
            </div>

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.15em] ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9"/>
                            </svg>
                        </div>
                        <input type="email" name="email" required
                               class="w-full pl-12 pr-4 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-500/5 shadow-sm transition-all duration-300 text-slate-900 font-medium placeholder-slate-300"
                               placeholder="user@gmail.com">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.15em]">Password</label>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-12 pr-4 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-500/5 shadow-sm transition-all duration-300 text-slate-900 font-medium placeholder-slate-300"
                               placeholder="••••••••">
                    </div>
                </div>
                <button type="submit"
                        class="w-full bg-slate-900 hover:bg-red-600 text-white font-black py-5 rounded-2xl transition-all duration-500 shadow-xl shadow-slate-200 hover:shadow-red-200 uppercase tracking-[0.2em] text-sm flex items-center justify-center space-x-2">
                    <span>Masuk Dashboard</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection