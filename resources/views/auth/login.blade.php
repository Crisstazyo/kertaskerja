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

            {{-- ══ ERROR ALERT ══ --}}
            @if ($errors->any() || session('error'))
                <div class="mb-6 bg-red-50 border-2 border-red-200 rounded-2xl px-5 py-4 flex items-start space-x-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-red-700 uppercase tracking-wider mb-1">Login Gagal</p>
                        @if (session('error'))
                            <p class="text-sm text-red-600 font-medium">{{ session('error') }}</p>
                        @endif
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600 font-medium">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form action="{{ route('auth.login') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.15em] ml-1">Email Address</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9"/>
                            </svg>
                        </div>
                        <input type="email" name="email" required
                               value="{{ old('email') }}"
                               class="w-full pl-12 pr-4 py-4 bg-white border-2 {{ $errors->has('email') ? 'border-red-400' : 'border-slate-100' }} rounded-2xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-500/5 shadow-sm transition-all duration-300 text-slate-900 font-medium placeholder-slate-300"
                               placeholder="user@gmail.com">
                    </div>
                    @error('email')
                        <p class="text-xs text-red-500 font-semibold ml-1 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="text-[11px] font-black text-slate-500 uppercase tracking-[0.15em] px-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               id="passwordInput"
                               class="w-full pl-12 pr-12 py-4 bg-white border-2 {{ $errors->has('password') ? 'border-red-400' : 'border-slate-100' }} rounded-2xl focus:outline-none focus:border-red-600 focus:ring-4 focus:ring-red-500/5 shadow-sm transition-all duration-300 text-slate-900 font-medium placeholder-slate-300"
                               placeholder="••••••••">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-red-600 transition-colors">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-xs text-red-500 font-semibold ml-1 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </p>
                    @enderror
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

<script>
function togglePassword() {
    const input      = document.getElementById('passwordInput');
    const eyeIcon    = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.add('hidden');
        eyeOffIcon.classList.remove('hidden');
    } else {
        input.type = 'password';
        eyeIcon.classList.remove('hidden');
        eyeOffIcon.classList.add('hidden');
    }
}
</script>
@endsection
