@extends('layouts.app')

@section('title', 'Private - PSAK')

@section('content')
<div class="min-h-screen" style="background:#f1f5f9;">
    <div class="max-w-7xl mx-auto px-8 py-10">

        {{-- ══ HEADER ══ --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-10 relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1.5"
                style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
            <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;"></div>
            <div class="relative flex items-center justify-between">
                <div class="flex items-center space-x-6">
                    <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                    <div class="w-px h-12 bg-slate-200"></div>
                    <div>
                        <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                        <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                            PSAK <span class="text-red-600">Private</span>
                        </h1>
                        <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Input Data PSAK — {{ now()->format('d F Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('private.dashboard') }}"
                        class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                        <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Back to Dashboard</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ FLASH MESSAGE ══ --}}
        <div id="successMessage" class="hidden flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Data PSAK berhasil disimpan!</span>
        </div>

        {{-- ══ FORM ══ --}}
        <form id="psakForm">
            @csrf

            {{-- SSL --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-6">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                        <div>
                            <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">SSL</h2>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">Commitment & realisasi format SSL.</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">SSL</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Commitment (SSL)</label>
                        <input type="text" name="commitment_ssl" value="{{ $psak->commitment_ssl ?? '' }}"
                            placeholder="cth: 150"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Realisasi (SSL)</label>
                        <input type="text" name="real_ssl" value="{{ $psak->real_ssl ?? '' }}"
                            placeholder="cth: 140"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                    </div>
                </div>
            </div>

            {{-- Rupiah --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                        <div>
                            <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Rupiah (Rp)</h2>
                            <p class="text-xs text-slate-400 font-semibold mt-0.5">Commitment & realisasi format rupiah.</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-black tracking-widest text-red-600 bg-red-50 border border-red-100 rounded-md px-3 py-1 uppercase">RP</span>
                </div>
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Commitment (Rp)</label>
                        <input type="text" name="commitment_rp" value="{{ $psak->commitment_rp ?? '' }}"
                            placeholder="cth: 50000000"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Realisasi (Rp)</label>
                        <input type="text" name="real_rp" value="{{ $psak->real_rp ?? '' }}"
                            placeholder="cth: 48000000"
                            class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-3 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>Simpan Data PSAK</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#psakForm').on('submit', function(e) {
        e.preventDefault();
        savePsakData();
    });

    function savePsakData() {
        const formData = new FormData($('#psakForm')[0]);

        $.ajax({
            url: '{{ route("private.psak.save") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const msg = document.getElementById('successMessage');
                msg.classList.remove('hidden');
                setTimeout(function() { msg.classList.add('hidden'); }, 3000);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: 'Data PSAK berhasil disimpan!', timer: 2000, showConfirmButton: false });
                }
            },
            error: function(xhr) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Terjadi kesalahan saat menyimpan data!' });
                } else {
                    alert('Terjadi kesalahan saat menyimpan data!');
                }
            }
        });
    }
});
</script>
@endsection
