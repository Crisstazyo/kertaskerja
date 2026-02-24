@extends('layouts.app')

@section('title', 'Admin Dashboard - Management')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">👨‍💼 Admin Dashboard</h1>
                        <p class="text-gray-600 text-lg">Kertas Kerja Management System</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                            🚪 Logout
                        </button>
                    </form>
                </div>
                <div class="h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 rounded-full"></div>
            </div>

            <!-- Entity Management Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Government Management Card -->
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-green-100 hover:border-green-300 transition-all duration-300 transform hover:scale-105">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 text-white">
                        <div class="flex items-center justify-center space-x-3 mb-2">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-4xl">🏛️</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Government</h2>
                                <p class="text-green-100 text-sm">Pemerintah</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk instansi pemerintah</p>
                        <div class="space-y-3">
                            <!-- Scalling Button -->
                            <a href="{{ route('admin.lop.type-select', 'government') }}" class="block">
                                <div
                                    class="border-2 border-green-200 rounded-lg p-4 hover:border-green-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200">
                                    <div class="flex items-center justify-center space-x-3">
                                        <span class="text-3xl">📊</span>
                                        <div class="text-left">
                                            <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                            <p class="text-xs text-gray-600">Manage Data</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Private Management Card -->
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 transform hover:scale-105">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 text-white">
                        <div class="flex items-center justify-center space-x-3 mb-2">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-4xl">🏢</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Private</h2>
                                <p class="text-blue-100 text-sm">Swasta</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk perusahaan swasta</p>
                        <div class="space-y-3">
                            <!-- Scalling Button -->
                            <a href="{{ route('admin.lop.type-select', 'private') }}" class="block">
                                <div
                                    class="border-2 border-blue-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200">
                                    <div class="flex items-center justify-center space-x-3">
                                        <span class="text-3xl">📊</span>
                                        <div class="text-left">
                                            <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                            <p class="text-xs text-gray-600">Manage Data</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- SOE Management Card -->
                <div
                    class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100 hover:border-purple-300 transition-all duration-300 transform hover:scale-105">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 text-white">
                        <div class="flex items-center justify-center space-x-3 mb-2">
                            <div class="bg-white bg-opacity-20 p-3 rounded-lg">
                                <span class="text-4xl">🏭</span>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">SOE</h2>
                                <p class="text-purple-100 text-sm">BUMN</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-6 text-center">Kelola data kertas kerja untuk BUMN</p>
                        <div class="space-y-3">
                            <!-- Scalling Button -->
                            <a href="{{ route('admin.lop.type-select', 'soe') }}" class="block">
                                <div
                                    class="border-2 border-purple-200 rounded-lg p-4 hover:border-purple-500 hover:shadow-lg transition-all duration-300 cursor-pointer bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200">
                                    <div class="flex items-center justify-center space-x-3">
                                        <span class="text-3xl">📊</span>
                                        <div class="text-left">
                                            <h3 class="font-bold text-gray-800 text-lg">Scalling & PSAK</h3>
                                            <p class="text-xs text-gray-600">Manage Data</p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Section -->
            <div class="mt-8 bg-white rounded-xl shadow-lg p-6 border-2 border-gray-100">
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <span class="text-3xl">💡</span>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Panduan Penggunaan</h3>
                        <ul class="space-y-2 text-gray-600">
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Pilih entity (Government/Private/SOE) untuk memulai</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Pilih tipe data (Scalling atau PSAK)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Untuk Scalling: Pilih kategori LOP (On Hand, Qualified, Koreksi, atau Initiate)</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Import Excel untuk On Hand, Qualified, dan Koreksi secara bersamaan</span>
                            </li>
                            <li class="flex items-start">
                                <span class="mr-2">•</span>
                                <span>Tambah data manual untuk LOP Initiate</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Report Table -->
            <div class="mt-8 bg-white p-4">
                <div class="overflow-x-auto">

                    @php
                        function getColorClass($value, $fairness)
                        {
                            if ($value == '-' || $value === null) {
                                return '';
                            }

                            $value = floatval(str_replace('%', '', $value));
                            switch ($fairness) {
                                case '96-100':
                                    if ($value < 98)
                                        return 'bg-black text-white';
                                    if ($value < 99.2)
                                        return 'bg-red-500 text-white';
                                    if ($value < 100)
                                        return 'bg-yellow-300';
                                    return 'bg-green-500 text-white';

                                case '99-100':
                                    if ($value < 99.5)
                                        return 'bg-black text-white';
                                    if ($value < 99.8)
                                        return 'bg-red-500 text-white';
                                    if ($value < 100)
                                        return 'bg-yellow-300';
                                    return 'bg-green-500 text-white';

                                case '90-100':
                                    if ($value < 95)
                                        return 'bg-black text-white';
                                    if ($value < 98)
                                        return 'bg-red-500 text-white';
                                    if ($value < 100)
                                        return 'bg-yellow-300';
                                    return 'bg-green-500 text-white';

                                case '0-100':
                                    if ($value < 50)
                                        return 'bg-black text-white';
                                    if ($value < 80)
                                        return 'bg-red-500 text-white';
                                    if ($value < 100)
                                        return 'bg-yellow-300';
                                    return 'bg-green-500 text-white';

                                default:
                                    return '';
                            }
                        }
                    @endphp

                    <table class="min-w-full border-collapse border border-gray-400 text-[11px] font-sans">
                        <thead class="bg-[#4a7795] text-white">
                            <tr>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-10">Nbr</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center">Unit / Scope</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 text-center">Indicator</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-12">Denom</th>
                                <th colspan="2" class="border border-gray-300 px-2 py-1 text-center">Commitment</th>
                                <th colspan="2" class="border border-gray-300 px-2 py-1 text-center">Real</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-16">Fairness</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-16">Ach</th>
                                <th rowspan="2" class="border border-gray-300 px-2 py-2 w-16">Score</th>
                            </tr>
                            <tr class="text-center">
                                <th class="border border-gray-300 px-2 py-1">Amount</th>
                                <th class="border border-gray-300 px-2 py-1">Rp Million</th>
                                <th class="border border-gray-300 px-2 py-1">Amount</th>
                                <th class="border border-gray-300 px-2 py-1">Rp Million</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-800">
                            <tr class="border-b-2 border-black font-bold">
                                <td class="border border-gray-400 text-center">2</td>
                                <td colspan="10" class="border border-gray-400 px-2 py-1 uppercase bg-gray-50">Collection
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="25" class="border border-gray-400"></td>

                                <td class="border border-gray-400 px-2 py-1">a C3MR</td>
                                <td class="border border-gray-400 px-2 py-1"></td>
                                <td class="border border-gray-400 text-center">%</td>

                                @php
                                    $commitC3mr = 98.0;
                                    $realC3mr = 95.7;
                                    $scoreC3mr = $commitC3mr == 0 ? '-' : number_format(($realC3mr / $commitC3mr) * 100, 1) . '%';
                                @endphp

                                <td class="border border-gray-400 px-2 text-right">{{ $commitC3mr }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realC3mr }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">96-100</td>

                                @php
                                    $fairnessC3mr = '96-100';
                                    $scoreC3mr = $commitC3mr == 0 ? '-' : number_format(($realC3mr / $commitC3mr) * 100, 1) . '%';
                                    $colorC3mr = getColorClass($scoreC3mr, $fairnessC3mr);
                                @endphp

                                <td colspan="2" class="border border-gray-400 text-right font-bold {{ $colorC3mr }}">
                                    {{ $scoreC3mr }}
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">b Bilper</td>
                                <td class="border border-gray-400 px-2 py-1"></td>
                                <td class="border border-gray-400 text-center">%</td>

                                @php
                                    $commitBilper = 100.0;
                                    $realBilper = 96.1;
                                    $scoreBilper = $commitBilper == 0 ? '-' : number_format(($realBilper / $commitBilper) * 100, 1) . '%';
                                @endphp

                                <td class="border border-gray-400 px-2 text-right">{{ $commitBilper }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realBilper }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">99-100</td>

                                @php
                                    $fairnessBilper = '99-100';
                                    $scoreBilper = $commitBilper == 0 ? '-' : number_format(($realBilper / $commitBilper) * 100, 1) . '%';
                                    $colorBilper = getColorClass($scoreBilper, $fairnessBilper);
                                @endphp

                                <td colspan="2" class="border border-gray-400 text-right font-bold {{ $colorBilper }}">
                                    {{ $scoreBilper }}
                                </td>
                            </tr>

                            @php
                                $fairnessCR = '90-100';

                                $commitCRGov = 77.8 ?? 0;
                                $realCRGov = 75.9 ?? 0;

                                $scoreCRGovValue = $commitCRGov == 0 ? 0 : ($realCRGov / $commitCRGov) * 100;
                                $scoreCRGovFormatted = $commitCRGov == 0 ? '-' : number_format($scoreCRGovValue, 1) . '%';
                                $colorCRGov = getColorClass($scoreCRGovFormatted, $fairnessCR);

                                $commitCRSME = 77.1 ?? 0;
                                $realCRSME = 77.9 ?? 0;

                                $scoreCRSMEValue = $commitCRSME == 0 ? 0 : ($realCRSME / $commitCRSME) * 100;
                                $scoreCRSMEFormatted = $commitCRSME == 0 ? '-' : number_format($scoreCRSMEValue, 1) . '%';
                                $colorCRSME = getColorClass($scoreCRSMEFormatted, $fairnessCR);

                                $commitCRPrivate = 91.5 ?? 0;
                                $realCRPrivate = 86.8 ?? 0;

                                $scoreCRPrivateValue = $commitCRPrivate == 0 ? 0 : ($realCRPrivate / $commitCRPrivate) * 100;
                                $scoreCRPrivateFormatted = $commitCRPrivate == 0 ? '-' : number_format($scoreCRPrivateValue, 1) . '%';
                                $colorCRPrivate = getColorClass($scoreCRPrivateFormatted, $fairnessCR);

                                $commitCRSOE = 75.7 ?? 0;
                                $realCRSOE = 67.7 ?? 0;

                                $scoreCRSOEValue = $commitCRSOE == 0 ? 0 : ($realCRSOE / $commitCRSOE) * 100;
                                $scoreCRSOEFormatted = $commitCRSOE == 0 ? '-' : number_format($scoreCRSOEValue, 1) . '%';
                                $colorCRSOE = getColorClass($scoreCRSOEFormatted, $fairnessCR);

                                $scoreCRTotalValue =
                                    ($scoreCRGovValue * 0.4) +
                                    ($scoreCRSMEValue * 0.2) +
                                    ($scoreCRPrivateValue * 0.2) +
                                    ($scoreCRSOEValue * 0.2);

                                $scoreCRTotalFormatted = number_format($scoreCRTotalValue, 1) . '%';
                                $colorScoreCR = getColorClass($scoreCRTotalFormatted, $fairnessCR);
                            @endphp

                            <tr>
                                <td rowspan="4" class="border border-gray-400 px-2 py-1 align-top">c CR</td>
                                <td class="border border-gray-400 px-2 py-1">CR Gov</td>
                                <td class="border border-gray-400 text-center">%</td>

                                <td class="border border-gray-400 px-2 text-right">{{ $commitCRGov }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realCRGov }}</td>
                                <td class="border border-gray-400"></td>

                                <td rowspan="4" class="border border-gray-400 text-center align-middle">
                                    {{ $fairnessCR }}
                                </td>

                                <td class="border border-gray-400 text-center font-bold {{ $colorCRGov }}">
                                    {{ $scoreCRGovFormatted }}
                                </td>

                                <td rowspan="4"
                                    class="border border-gray-400 text-center font-bold align-middle {{ $colorScoreCR }}">
                                    {{ $scoreCRTotalFormatted }}
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">CR SME</td>
                                <td class="border border-gray-400 text-center">%</td>

                                <td class="border border-gray-400 px-2 text-right">{{ $commitCRSME }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realCRSME }}</td>
                                <td class="border border-gray-400"></td>

                                <td class="border border-gray-400 text-center font-bold {{ $colorCRSME }}">
                                    {{ $scoreCRSMEFormatted }}
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">CR Private</td>
                                <td class="border border-gray-400 text-center">%</td>

                                <td class="border border-gray-400 px-2 text-right">{{ $commitCRPrivate }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realCRPrivate }}</td>
                                <td class="border border-gray-400"></td>

                                <td class="border border-gray-400 text-center font-bold {{ $colorCRPrivate }}">
                                    {{ $scoreCRPrivateFormatted }}
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">CR SOE</td>
                                <td class="border border-gray-400 text-center">%</td>

                                <td class="border border-gray-400 px-2 text-right">{{ $commitCRSOE }}</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">{{ $realCRSOE }}</td>
                                <td class="border border-gray-400"></td>

                                <td class="border border-gray-400 text-center font-bold {{ $colorCRSOE }}">
                                    {{ $scoreCRSOEFormatted }}
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="19" class="border border-gray-400 px-2 py-1 align-top">d UTIP</td>
                                <td class="border border-gray-400 px-2 py-1">UTIP Corrective</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">21.406</td>
                                <td class="border border-gray-400 px-2 text-right">13.368</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">15.063</td>
                                <td rowspan="19" class="border border-gray-400 text-center align-middle">0-100</td>
                                <td class="border border-gray-400 text-center bg-[#5cb874] text-white font-bold">112,68%
                                </td>
                                <td rowspan="19"
                                    class="border border-gray-400 bg-[#82d682] text-center font-bold align-middle">113,0%
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Jul 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">2.125</td>
                                <td class="border border-gray-400 px-2 text-right">2.125</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">2.009</td>
                                <td class="border border-gray-400 text-center bg-[#fdf2a7] font-bold">94,54%</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Aug 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">4.279</td>
                                <td class="border border-gray-400 px-2 text-right">3.981</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">3.472</td>
                                <td class="border border-gray-400 text-center bg-[#fdf2a7] font-bold">87,23%</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Sep 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">7.286</td>
                                <td class="border border-gray-400 px-2 text-right">6.100</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">6.554</td>
                                <td class="border border-gray-400 text-center bg-[#5cb874] text-white font-bold">107,45%
                                </td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Oct 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400 px-2 text-right">4.330</td>
                                <td class="border border-gray-400 px-2 text-right">1.354</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 px-2 text-right">3.323</td>
                                <td class="border border-gray-400 text-center bg-[#5cb874] text-white font-bold">245,37%
                                </td>
                            </tr>

                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Nov 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Des 2025</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Jan 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Feb 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Mar 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Apr 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP May 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Jun 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Jul 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Aug 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Sep 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Oct 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Nov 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                            <tr>
                                <td class="border border-gray-400 px-2 py-1">New UTIP Des 2026</td>
                                <td class="border border-gray-400 text-center">Rp</td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400"></td>
                                <td class="border border-gray-400 text-center">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
