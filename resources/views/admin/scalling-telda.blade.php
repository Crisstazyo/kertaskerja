@extends('layouts.app')

@section('title', 'Scaling Telda - Admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">← Back to Dashboard</a>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Scaling Telda</h1>
                    <p class="text-gray-600">Admin input Commitment (Rp) - User input Real (Rp)</p>
                </div>
            </div>
            <div class="h-px bg-gray-200"></div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Input Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Input Data</h2>
            
            <form action="{{ route('admin.scalling.telda.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="periode" class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                        <input type="month" 
                               id="periode" 
                               name="periode" 
                               required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('periode')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="commitment" class="block text-sm font-medium text-gray-700 mb-2">Commitment (Rp) - Optional</label>
                        <input type="number" 
                               id="commitment" 
                               name="commitment" 
                               step="0.01"
                               placeholder="Contoh: 50000000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('commitment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="real" class="block text-sm font-medium text-gray-700 mb-2">Real (Rp) - Optional</label>
                        <input type="number" 
                               id="real" 
                               name="real" 
                               step="0.01"
                               placeholder="Contoh: 48000000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        @error('real')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white px-6 py-2 rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Data Scaling Telda</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commitment</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Real</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Achievement %</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Input</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($item->periode)->format('F Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->user->name ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-orange-600">
                                    Rp {{ number_format($item->commitment, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">
                                    {{ $item->real ? 'Rp ' . number_format($item->real, 0, ',', '.') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($item->real && $item->commitment > 0)
                                        @php
                                            $achievement = ($item->real / $item->commitment) * 100;
                                        @endphp
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $achievement >= 100 ? 'bg-green-100 text-green-800' : ($achievement >= 80 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ number_format($achievement, 1) }}%
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada data</p>
                                        <p class="text-sm">Silakan input data terlebih dahulu</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
