@extends('layouts.app')

@section('title', 'Admin - PSAK ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('admin.role.menu', $role) }}" class="text-blue-600 hover:text-blue-800 mb-2 inline-block text-sm font-medium">
                        ← Kembali ke {{ ucfirst($role) }} Menu
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">PSAK Data - {{ ucfirst($role) }}</h1>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        @if($psakData->count() > 0)
        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-4 text-left text-xs font-bold uppercase tracking-wider">User</th>
                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-wider">Commitment<br>SSL</th>
                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-wider">Real<br>SSL</th>
                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-wider">Commitment<br>Rp</th>
                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-wider">Real<br>Rp</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($psakData as $psak)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($psak->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900">
                                {{ $psak->user->name ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                {{ $psak->commitment_ssl ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                {{ $psak->real_ssl ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                {{ $psak->commitment_rp ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-right text-gray-900">
                                {{ $psak->real_rp ?? '-' }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-500">
                <p class="text-gray-500 text-sm font-semibold">Total Entries</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $psakData->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <p class="text-gray-500 text-sm font-semibold">Active Users</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $psakData->unique('user_id')->count() }}</p>
            </div>
        </div>
        @else
        <!-- No Data Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-16 text-center">
            <div class="max-w-md mx-auto">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Data PSAK</h2>
                <p class="text-gray-600">
                    Data PSAK untuk role {{ ucfirst($role) }} belum tersedia. User dapat menginput data PSAK melalui dashboard mereka.
                </p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
