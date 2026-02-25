@extends('layouts.app')

@section('title', 'Collection Ratio')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-indigo-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📈 Collection Ratio</h1>
                    <p class="text-gray-600 text-lg">Performance Metrics & Analysis</p>
                </div>
                <a href="{{ route('collection.dashboard') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-md hover:shadow-lg">
                    ← Back to Dashboard
                </a>
            </div>
            <div class="h-1 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-full"></div>
        </div>

        <!-- Summary Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                <h2 class="text-xl font-bold text-white">📊 Summary Collection Ratio - Periode {{ now()->translatedFormat('F Y') }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider">Segment</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Commitment (%)</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Real (%)</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $currentMonth = now()->month;
                            $currentYear = now()->year;
                            
                            // Get data for C3MR
                            $c3mrCommitment = \App\Models\C3mr::where('user_id', Auth::id())
                                ->where('type', 'komitmen')
                                ->where('month', $currentMonth)
                                ->where('year', $currentYear)
                                ->first();
                            
                            $c3mrRealisasi = \App\Models\C3mr::where('user_id', Auth::id())
                                ->where('type', 'realisasi')
                                ->where('month', $currentMonth)
                                ->where('year', $currentYear)
                                ->avg('ratio');
                            
                            // Get data for Billing Perdana
                            $billingCommitment = \App\Models\BillingPerdanan::where('user_id', Auth::id())
                                ->where('type', 'komitmen')
                                ->where('month', $currentMonth)
                                ->where('year', $currentYear)
                                ->first();
                            
                            $billingRealisasi = \App\Models\BillingPerdanan::where('user_id', Auth::id())
                                ->where('type', 'realisasi')
                                ->where('month', $currentMonth)
                                ->where('year', $currentYear)
                                ->avg('ratio');
                            
                            // CR Segments data
                            $segments = [
                                ['name' => 'C3MR', 'key' => 'c3mr', 'color' => 'purple', 'type' => 'special', 'commitment' => $c3mrCommitment, 'realisasi' => $c3mrRealisasi],
                                ['name' => 'Billing Perdana', 'key' => 'billing', 'color' => 'pink', 'type' => 'special', 'commitment' => $billingCommitment, 'realisasi' => $billingRealisasi],
                                ['name' => 'CR SME', 'key' => 'sme', 'color' => 'blue', 'type' => 'cr'],
                                ['name' => 'CR Gov', 'key' => 'gov', 'color' => 'green', 'type' => 'cr'],
                                ['name' => 'CR Private', 'key' => 'private', 'color' => 'purple', 'type' => 'cr'],
                                ['name' => 'CR SOE', 'key' => 'soe', 'color' => 'orange', 'type' => 'cr']
                            ];
                        @endphp
                        
                        @foreach($segments as $segment)
                            @php
                                if ($segment['type'] == 'special') {
                                    // For C3MR and Billing Perdana
                                    $commitmentValue = $segment['commitment'] ? $segment['commitment']->ratio : 0;
                                    $realValue = $segment['realisasi'] ? round($segment['realisasi'], 2) : 0;
                                } else {
                                    // For CR segments
                                    // Get commitment for current month
                                    $commitment = \App\Models\CollectionRatioData::where('user_id', Auth::id())
                                        ->where('segment', $segment['key'])
                                        ->where('type', 'komitmen')
                                        ->where('month', $currentMonth)
                                        ->where('year', $currentYear)
                                        ->first();
                                
                                // Get average realisasi for current month
                                $realisasiAvg = \App\Models\CollectionRatioData::where('user_id', Auth::id())
                                    ->where('segment', $segment['key'])
                                    ->where('type', 'realisasi')
                                    ->where('month', $currentMonth)
                                    ->where('year', $currentYear)
                                    ->avg('ratio_aktual');
                                
                                    $commitmentValue = $commitment ? $commitment->target_ratio : 0;
                                    $realValue = $realisasiAvg ? round($realisasiAvg, 2) : 0;
                                }
                                
                                // Calculate status
                                $status = '';
                                $statusClass = '';
                                if ($commitmentValue > 0 && $realValue > 0) {
                                    if ($realValue >= $commitmentValue) {
                                        $status = 'Achieved';
                                        $statusClass = 'bg-green-100 text-green-800';
                                    } else {
                                        $status = 'Below Target';
                                        $statusClass = 'bg-red-100 text-red-800';
                                    }
                                } else {
                                    $status = 'No Data';
                                    $statusClass = 'bg-gray-100 text-gray-600';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full bg-{{ $segment['color'] }}-500 mr-3"></div>
                                        <span class="font-semibold text-gray-900">{{ $segment['name'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-{{ $segment['color'] }}-600">
                                        {{ number_format($commitmentValue, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-lg font-bold text-gray-900">
                                        {{ number_format($realValue, 2) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                        {{ $status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-6 py-3 text-center border-t border-gray-200">
                <p class="text-xs text-gray-500 italic">Data diperbarui secara real-time berdasarkan input komitmen dan realisasi</p>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- CR SME -->
            <a href="{{ route('collection.cr-sme') }}" class="group">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">CR SME</h2>
                            <p class="text-blue-100 text-sm mb-6">Collection Ratio untuk Segmen SME</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-8 py-4 flex items-center justify-between group-hover:bg-white/20 transition-all">
                        <span class="text-white font-semibold">Open CR SME</span>
                        <svg class="w-5 h-5 text-white transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- CR Gov -->
            <a href="{{ route('collection.cr-gov') }}" class="group">
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">CR Gov</h2>
                            <p class="text-green-100 text-sm mb-6">Collection Ratio untuk Segmen Government</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-8 py-4 flex items-center justify-between group-hover:bg-white/20 transition-all">
                        <span class="text-white font-semibold">Open CR Gov</span>
                        <svg class="w-5 h-5 text-white transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- CR Private -->
            <a href="{{ route('collection.cr-private') }}" class="group">
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">CR Private</h2>
                            <p class="text-purple-100 text-sm mb-6">Collection Ratio untuk Segmen Private</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-8 py-4 flex items-center justify-between group-hover:bg-white/20 transition-all">
                        <span class="text-white font-semibold">Open CR Private</span>
                        <svg class="w-5 h-5 text-white transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>

            <!-- CR SOE -->
            <a href="{{ route('collection.cr-soe') }}" class="group">
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 overflow-hidden">
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-6">
                            <div class="bg-white/20 backdrop-blur-sm p-4 rounded-xl">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">CR SOE</h2>
                            <p class="text-orange-100 text-sm mb-6">Collection Ratio untuk Segmen State-Owned Enterprise</p>
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-8 py-4 flex items-center justify-between group-hover:bg-white/20 transition-all">
                        <span class="text-white font-semibold">Open CR SOE</span>
                        <svg class="w-5 h-5 text-white transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
