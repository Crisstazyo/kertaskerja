@extends('layouts.app')

@section('title', 'Government - Scalling')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 relative overflow-hidden">
    <!-- Decorative Background Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full filter blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-gradient-to-tl from-indigo-100 to-indigo-50 rounded-full filter blur-3xl opacity-40 translate-x-1/2 translate-y-1/2"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-200/50 p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('gov.dashboard') }}" class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-all duration-200 shadow-lg hover:shadow-xl flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Dashboard
                        </a>
                        <div class="border-l-2 border-gray-300 h-12"></div>
                        <div>
                            <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Scalling Management</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOP Categories Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- LOP On Hand Card -->
            <a href="{{ route('gov.lop-on-hand') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-teal-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>

                    <div class="relative">
                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">LOP On Hand</h2>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-emerald-600 font-bold group-hover:text-emerald-700 transition-colors">
                                    <span>Open Data</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Qualified Card -->
            <a href="{{ route('gov.lop-qualified') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-500 to-fuchsia-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>

                    <div class="relative">
                        <div class="bg-gradient-to-br from-purple-500 to-fuchsia-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">LOP Qualified</h2>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-purple-600 font-bold group-hover:text-purple-700 transition-colors">
                                    <span>Open Data</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <!-- LOP Koreksi Card -->
            <a href="{{ route('gov.lop-koreksi') }}" class="group">
                <div class="relative bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3">
                    <div class="absolute inset-0 bg-gradient-to-br from-pink-500 to-rose-600 opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>

                    <div class="relative">
                        <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-10 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="absolute -bottom-6 -left-6 w-40 h-40 bg-white/5 rounded-full"></div>
                            <div class="relative">
                                <div class="flex items-start justify-between mb-6">
                                    <div>
                                        <h2 class="text-3xl font-bold mb-2">LOP Koreksi</h2>
                                    </div>
                                    <span class="px-4 py-1.5 bg-white/20 backdrop-blur-sm text-xs font-bold rounded-full">ACTIVE</span>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-pink-600 font-bold group-hover:text-pink-700 transition-colors">
                                    <span>Open Data</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Scalling Table Section (Admin Upload + Checkbox) -->
        <div class="mt-14">
            <div class="mb-6 flex items-center gap-3">
                <div class="w-1 h-8 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></div>
                <h2 class="text-2xl font-bold text-gray-800">Scalling Table</h2>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 rounded-full px-3 py-1 uppercase tracking-wider">Interactive Checklist</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                $scallingCards = [
                    ['key' => 'on-hand',  'label' => 'LOP On Hand',  'from' => 'from-emerald-500', 'to' => 'to-teal-600',    'text' => 'text-emerald-600'],
                    ['key' => 'qualified','label' => 'LOP Qualified','from' => 'from-purple-500',  'to' => 'to-fuchsia-600', 'text' => 'text-purple-600'],
                    ['key' => 'koreksi',  'label' => 'LOP Koreksi',  'from' => 'from-orange-500',  'to' => 'to-red-600',     'text' => 'text-orange-600'],
                    ['key' => 'initiate', 'label' => 'LOP Initiate', 'from' => 'from-blue-500',    'to' => 'to-indigo-600',  'text' => 'text-blue-600'],
                ];
                @endphp
                @foreach($scallingCards as $card)
                <a href="{{ route('gov.scalling-lop-table', $card['key']) }}" class="group">
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden border border-gray-200/50 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2">
                        <div class="bg-gradient-to-br {{ $card['from'] }} {{ $card['to'] }} p-8 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                            <div class="relative">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xl font-bold">{{ $card['label'] }}</h3>
                                    <svg class="w-6 h-6 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                </div>
                                <span class="text-xs font-bold bg-white/20 backdrop-blur-sm rounded-full px-3 py-1">CHECKLIST</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center {{ $card['text'] }} font-bold group-hover:opacity-80 transition-opacity">
                                <span class="text-sm">Buka Tabel</span>
                                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
