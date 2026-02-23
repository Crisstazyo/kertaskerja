@extends('layouts.app')

@section('title', 'LOP Initiate History - Admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <a href="{{ route('admin.lop.initiate', $entity) }}" class="mr-4 text-gray-600 hover:text-gray-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-1">📜 LOP Initiate History</h1>
                        <p class="text-gray-600">{{ ucfirst($entity) }} - Riwayat Data</p>
                    </div>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full"></div>
        </div>

        @if($data->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 border-purple-100">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4 text-white">
                <h2 class="text-xl font-bold">📋 History Data LOP Initiate</h2>
                <p class="text-sm text-purple-100">Total: {{ $data->count() }} data</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">No</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Project</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID LOP</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">CC</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">NIPNAS</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">AM</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Mitra</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Plan Bulan</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Est Nilai BC</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Created By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Created At</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->no }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->project }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->id_lop }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->cc }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->nipnas }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->am }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->mitra }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->plan_bulan_billcom_p_2025 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->est_nilai_bc }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->created_by }}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $item->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border-2 border-gray-100">
            <span class="text-6xl mb-4 block">📭</span>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada History</h3>
            <p class="text-gray-600">Belum ada data yang pernah ditambahkan</p>
        </div>
        @endif
    </div>
</div>
@endsection
