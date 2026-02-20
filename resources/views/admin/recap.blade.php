@extends('layouts.app')

@section('title', 'Rekap ' . ucfirst($role))

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📊 Rekap {{ ucfirst($role) }}</h1>
                    <p class="text-gray-600">Semua worksheet untuk role {{ ucfirst($role) }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition duration-300">
                        ← Kembali ke Admin Panel
                    </a>
                </div>
            </div>
        </div>

        <!-- Worksheets -->
        @forelse($worksheets as $worksheet)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="bg-gradient-to-r 
                {{ $role === 'government' ? 'from-green-500 to-green-600' : '' }}
                {{ $role === 'private' ? 'from-yellow-500 to-yellow-600' : '' }}
                {{ $role === 'soe' ? 'from-purple-500 to-purple-600' : '' }} 
                text-white px-6 py-4 rounded-t-lg -mx-6 -mt-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $worksheet->full_name }}</h2>
                        <div class="text-sm opacity-90">{{ $worksheet->projects->count() }} projects</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm opacity-90">Tipe: {{ $worksheet->type_name }}</div>
                        @if($worksheet->lop_category)
                            <div class="text-sm opacity-90">{{ $worksheet->lop_category_name }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left">No</th>
                            <th class="px-3 py-2 text-left">Project Name</th>
                            <th class="px-3 py-2 text-left">CC</th>
                            <th class="px-3 py-2 text-left">AM</th>
                            <th class="px-3 py-2 text-left">Segmen</th>
                            <th class="px-3 py-2 text-left">Mitra</th>
                            <th class="px-3 py-2 text-center">F0</th>
                            <th class="px-3 py-2 text-center">F1</th>
                            <th class="px-3 py-2 text-center">F2</th>
                            <th class="px-3 py-2 text-center">F3</th>
                            <th class="px-3 py-2 text-center">F4</th>
                            <th class="px-3 py-2 text-center">F5</th>
                            <th class="px-3 py-2 text-left">Delivery</th>
                            <th class="px-3 py-2 text-left">Billing</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($worksheet->projects as $index => $project)
                        <tr class="border-b hover:bg-gray-50 {{ $project->is_user_added ? 'bg-yellow-50' : '' }}">
                            <td class="px-3 py-2">{{ $project->is_user_added ? '★' : '' }} {{ $index + 1 }}</td>
                            <td class="px-3 py-2 font-medium">{{ $project->project_name }}</td>
                            <td class="px-3 py-2">{{ $project->cc }}</td>
                            <td class="px-3 py-2">{{ $project->am }}</td>
                            <td class="px-3 py-2">{{ $project->segmen }}</td>
                            <td class="px-3 py-2">{{ $project->mitra }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f0 }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f1 }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f2 }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f3 }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f4 }}</td>
                            <td class="px-3 py-2 text-center">{{ $project->f5 }}</td>
                            <td class="px-3 py-2">
                                <div>KL: {{ $project->kontrak_layanan }}</div>
                                <div>BAUT: {{ $project->baut_bast }}</div>
                                <div>BASO: {{ $project->baso }}</div>
                            </td>
                            <td class="px-3 py-2">
                                <div>Invoice: {{ $project->invoice }}</div>
                                <div>AR: {{ $project->ar }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="14" class="px-3 py-8 text-center text-gray-500">
                                Belum ada project dalam worksheet ini
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-lg shadow-md p-8 text-center text-gray-500">
            <p class="text-xl">Belum ada worksheet untuk role {{ ucfirst($role) }}</p>
            <p class="mt-2">Buat worksheet baru di Admin Panel</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
