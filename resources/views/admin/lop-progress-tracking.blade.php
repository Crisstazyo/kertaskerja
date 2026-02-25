@extends('layouts.app')

@section('title', 'Admin - LOP Progress Tracking')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-50 py-12">
    <div class="max-w-[98%] mx-auto px-6">
        <!-- Professional Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-2 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Back to Dashboard
                    </a>
                    <div class="h-6 w-px bg-gray-300"></div>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">LOP Progress Tracking</h1>
                            <span class="px-3 py-1 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-xs font-semibold rounded-full shadow-sm">ADMIN VIEW</span>
                        </div>
                        <p class="text-sm text-gray-500">Monitor team progress updates across all LOP categories</p>
                    </div>
                </div>
            </div>
            <div class="h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
        </div>

        <!-- Tabs for different categories -->
        <div class="bg-white rounded-t-2xl border border-b-0 border-gray-200">
            <div class="flex border-b border-gray-200">
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-700 border-b-2 border-blue-600 bg-blue-50" data-tab="on-hand">
                    On Hand
                    <span class="ml-2 px-2 py-0.5 bg-blue-600 text-white rounded-full text-xs">{{ $onHandData->count() }}</span>
                </button>
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300" data-tab="qualified">
                    Qualified
                    <span class="ml-2 px-2 py-0.5 bg-gray-400 text-white rounded-full text-xs">{{ $qualifiedData->count() }}</span>
                </button>
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300" data-tab="koreksi">
                    Koreksi
                    <span class="ml-2 px-2 py-0.5 bg-gray-400 text-white rounded-full text-xs">{{ $koreksiData->count() }}</span>
                </button>
                <button class="tab-btn px-6 py-4 text-sm font-semibold text-gray-500 border-b-2 border-transparent hover:text-gray-700 hover:border-gray-300" data-tab="initiate">
                    Initiate
                    <span class="ml-2 px-2 py-0.5 bg-gray-400 text-white rounded-full text-xs">{{ $initiateData->count() }}</span>
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-b-2xl shadow-xl overflow-hidden border border-gray-200">
            <!-- On Hand Tab -->
            <div id="tab-on-hand" class="tab-content">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">ID LOP</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($onHandData as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $data->no }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->project }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->id_lop }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-1 justify-center">
                                        @foreach(['f0_inisiasi_solusi', 'f1_tech_budget', 'f2_p0_p1', 'f3_p6', 'f4_negosiasi', 'f5_ttd_kontrak', 'delivery_billing_complete'] as $stage)
                                            <div class="w-3 h-3 rounded-full {{ $data->funnel && $data->funnel->{$stage} ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ ucfirst(str_replace('_', ' ', $stage)) }}"></div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">No updates yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Qualified Tab -->
            <div id="tab-qualified" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">ID LOP</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($qualifiedData as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $data->no }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->project }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->id_lop }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-1 justify-center">
                                        @foreach(['f0_inisiasi_solusi', 'f1_tech_budget', 'f2_p0_p1', 'f3_p6', 'f4_negosiasi', 'f5_ttd_kontrak', 'delivery_billing_complete'] as $stage)
                                            <div class="w-3 h-3 rounded-full {{ $data->funnel && $data->funnel->{$stage} ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ ucfirst(str_replace('_', ' ', $stage)) }}"></div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">No updates yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Koreksi Tab -->
            <div id="tab-koreksi" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">ID LOP</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($koreksiData as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $data->no }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->project }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->id_lop }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-1 justify-center">
                                        @foreach(['f0_inisiasi_solusi', 'f1_tech_budget', 'f2_p0_p1', 'f3_p6', 'f4_negosiasi', 'f5_ttd_kontrak', 'delivery_billing_complete'] as $stage)
                                            <div class="w-3 h-3 rounded-full {{ $data->funnel && $data->funnel->{$stage} ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ ucfirst(str_replace('_', ' ', $stage)) }}"></div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">No updates yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Initiate Tab -->
            <div id="tab-initiate" class="tab-content hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-xs">
                        <thead class="bg-gradient-to-r from-slate-50 to-gray-100">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">No</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left font-bold text-gray-700 uppercase tracking-wider">ID LOP</th>
                                <th class="px-4 py-3 text-center font-bold text-gray-700 uppercase tracking-wider">Progress</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($initiateData as $data)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">{{ $data->no }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->project }}</td>
                                <td class="px-4 py-3 text-gray-700">{{ $data->id_lop }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex gap-1 justify-center">
                                        @foreach(['f0_inisiasi_solusi', 'f1_tech_budget', 'f2_p0_p1', 'f3_p6', 'f4_negosiasi', 'f5_ttd_kontrak', 'delivery_billing_complete'] as $stage)
                                            <div class="w-3 h-3 rounded-full {{ $data->funnel && $data->funnel->{$stage} ? 'bg-green-500' : 'bg-gray-300' }}" title="{{ ucfirst(str_replace('_', ' ', $stage)) }}"></div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500">No updates yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active state from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-600', 'bg-blue-50', 'text-gray-700');
                btn.classList.add('border-transparent', 'text-gray-500');
                const badge = btn.querySelector('span');
                if (badge) {
                    badge.classList.remove('bg-blue-600');
                    badge.classList.add('bg-gray-400');
                }
            });
            
            // Add active state to clicked button
            this.classList.remove('border-transparent', 'text-gray-500');
            this.classList.add('border-blue-600', 'bg-blue-50', 'text-gray-700');
            const activeBadge = this.querySelector('span');
            if (activeBadge) {
                activeBadge.classList.remove('bg-gray-400');
                activeBadge.classList.add('bg-blue-600');
            }
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target tab content
            document.getElementById(`tab-${targetTab}`).classList.remove('hidden');
        });
    });
});
</script>

@endsection
