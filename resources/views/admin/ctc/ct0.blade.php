@extends('layouts.app')

@section('title', 'Admin - Collections Management')

@section('content')
    <div class="min-h-screen" style="background:#f1f5f9;">
        <div class="max-w-7xl mx-auto px-8 py-10">

            {{-- ══ HEADER ══ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 px-10 py-7 mb-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1.5"
                    style="background: linear-gradient(90deg, #dc2626, #ef4444, #dc2626);"></div>
                <div class="absolute -right-10 -top-10 w-56 h-56 rounded-full opacity-[0.04]" style="background: #dc2626;">
                </div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <img src="{{ asset('img/Telkom.png') }}" alt="Telkom" class="h-12 w-auto">
                        <div class="w-px h-12 bg-slate-200"></div>
                        <div>
                            <p class="text-[10px] font-black tracking-[0.3em] text-red-600 uppercase mb-1">Witel Sumut</p>
                            <h1 class="text-2xl font-black tracking-tight text-slate-900 leading-none uppercase">
                                <span class="text-red-600">Paid</span> CT0
                            </h1>
                            <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-tight">Kelola data Paid CT0
                                semua user</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.index') }}"
                            class="flex items-center space-x-2.5 bg-white border-2 border-slate-900 hover:bg-red-600 hover:border-red-600 text-slate-900 hover:text-white px-6 py-3 rounded-xl font-black text-xs transition-all duration-300 shadow-sm group uppercase tracking-wider">
                            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Back to Dashboard</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="group flex items-center space-x-2.5 bg-slate-900 hover:bg-red-600 text-white font-bold text-sm px-5 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-4 h-4 transition-transform duration-300 group-hover:rotate-12" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
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
            @if(session('success'))
                <div
                    class="flex items-center space-x-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 mb-6 rounded-xl text-sm font-semibold">
                    <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- ══ INPUT FORM ══ --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
                <div class="px-8 py-5 border-b border-slate-100">
                    <div class="flex items-center space-x-3">
                        <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                        <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Input / Update Data Paid CT0
                        </h2>
                    </div>
                </div>
                <div class="p-8">
                    <form action="{{ route('admin.ct0.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">

                            {{-- User (readonly) --}}
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">User</label>
                                <input type="text" value="{{ auth()->user()->name }}" readonly
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 bg-slate-50 cursor-not-allowed">
                                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                            </div>

                            {{-- Periode --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Periode
                                </label>
                                <input type="month" name="periode" value="{{ old('periode', now()->format('Y-m')) }}"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                            </div>

                            {{-- Region --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">
                                    Region
                                </label>

                                <select name="region" required
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">

                                    <option value="" disabled {{ old('region') ? '' : 'selected' }}>
                                        — Pilih Region —
                                    </option>
                                    @php
                                        $regions = [
                                            'Inner Sumut',
                                            'Telda Lubuk Pakam',
                                            'Telda Binjai',
                                            'Telda Kisaran',
                                            'Telda Siantar',
                                            'Telda Kabanjahe',
                                            'Telda Rantauprapat',
                                            'Telda Sibolga',
                                            'Telda Padang Sidempuan',
                                        ];
                                    @endphp
                                    @foreach($regions as $region)
                                        <option value="{{ $region }}" {{ old('region') === $region ? 'selected' : '' }}>
                                            {{ $region }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                            {{-- Status --}}
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Status</label>
                                <select name="status" required
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors bg-white">
                                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            {{-- Commitment --}}
                            <div>
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Commitment</label>
                                <input type="text" name="commitment" value="{{ old('commitment') }}"
                                    placeholder="cth: Target Value"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                            </div>

                            {{-- Real Ratio --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Real
                                    Ratio (%)</label>
                                <input type="text" name="real_ratio" value="{{ old('real_ratio') }}"
                                    placeholder="cth: 95.50"
                                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 focus:outline-none focus:border-red-400 focus:ring-1 focus:ring-red-100 transition-colors">
                            </div>

                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="reset"
                                class="flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs px-5 py-2.5 rounded-xl transition-all duration-200 uppercase tracking-wider">
                                <span>Reset</span>
                            </button>
                            <button type="submit"
                                class="flex items-center space-x-2 bg-slate-900 hover:bg-red-600 text-white font-bold text-xs px-6 py-2.5 rounded-xl transition-all duration-200 uppercase tracking-wider shadow-md hover:shadow-lg hover:shadow-red-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Simpan / Update</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ══ FILTER & TABLE ══ --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-8 py-5 border-b border-slate-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-1.5 h-8 bg-red-600 rounded-full"></div>
                            <h2 class="text-base font-black text-slate-900 uppercase tracking-wide">Data Collections</h2>
                        </div>
                        <span class="text-[10px] font-black tracking-widest text-slate-400 uppercase">Total:
                            {{ $collections->total() }} data</span>
                    </div>
                    <div class="grid grid-cols-5 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Filter
                                User</label>
                            <select id="filterUser" onchange="filterTable()"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                                <option value="">Semua User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Status</label>
                            <select id="filterStatus" onchange="filterTable()"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                                <option value="">Semua Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Region</label>
                            <select id="filterRegion" onchange="filterTable()"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400 bg-white">
                                <option value="">Semua Region</option>
                                <option value="Inner Sumut">Inner Sumut</option>
                                <option value="Telda Lubuk Pakam">Telda Lubuk Pakam</option>
                                <option value="Telda Binjai">Telda Binjai</option>
                                <option value="Telda Kisaran">Telda Kisaran</option>
                                <option value="Telda Siantar">Telda Siantar</option>
                                <option value="Telda Kabanjahe">Telda Kabanjahe</option>
                                <option value="Telda Rantauprapat">Telda Rantauprapat</option>
                                <option value="Telda Sibolga">Telda Sibolga</option>
                                <option value="Telda Padang Sidempuan">Telda Padang Sidempuan</option>
                            </select>
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5">Cari</label>
                            <input type="text" id="filterSearch" placeholder="Cari..." oninput="filterTable()"
                                class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm font-semibold text-slate-700 focus:outline-none focus:border-red-400">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1.5 invisible">Reset</label>
                            <button onclick="resetFilters()"
                                class="w-full flex items-center justify-center space-x-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs rounded-lg transition-colors uppercase tracking-wider">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full" id="dataTable">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th
                                    class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    User</th>
                                <th
                                    class="px-6 py-3 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Region</th>
                                <th
                                    class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Periode</th>
                                <th
                                    class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Commitment</th>
                                <th
                                    class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Real Ratio</th>
                                <th
                                    class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    Updated</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($collections as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0"
                                                style="background:#fff1f2; border:1px solid #fecdd3;">
                                                <span
                                                    class="text-[10px] font-black text-red-600">{{ substr($item->user->name ?? 'U', 0, 1) }}</span>
                                            </div>
                                            <span
                                                class="text-sm font-semibold text-slate-700">{{ $item->user->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->region)
                                            <span
                                                class="text-xs font-bold rounded-md px-2.5 py-1 text-slate-700 bg-slate-100 border border-slate-200">
                                                {{ $item->region }}
                                            </span>
                                        @else
                                            <span class="text-sm text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-slate-600">
                                            {{ $item->periode ? \Carbon\Carbon::parse($item->periode)->format('M Y') : '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->commitment !== null && $item->commitment !== '')
                                            <span class="text-sm font-black text-slate-800">{{ $item->commitment }}</span>
                                        @else
                                            <span class="text-sm text-slate-400">—</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->real_ratio !== null && $item->real_ratio !== '')
                                            <span class="text-sm font-black text-red-600">{{ $item->real_ratio }}</span>
                                        @else
                                            <span
                                                class="text-xs font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-md px-2 py-0.5">Belum
                                                diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="text-xs font-bold rounded-md px-2.5 py-1
                                            {{ $item->status === 'active' ? 'text-green-700 bg-green-50 border border-green-200' : 'text-slate-500 bg-slate-50 border border-slate-200' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-slate-400">
                                        {{ $item->updated_at ? $item->updated_at->format('d M Y H:i') : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-16 text-center">
                                        <svg class="mx-auto w-10 h-10 text-slate-200 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-sm font-bold text-slate-400">Belum ada data CT0</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($collections->hasPages())
                    <div class="px-8 py-4 border-t border-slate-100">
                        {{ $collections->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        function filterTable() {
            const u = (document.getElementById('filterUser')?.value || '').toLowerCase();
            const st = (document.getElementById('filterStatus')?.value || '').toLowerCase();
            const rg = (document.getElementById('filterRegion')?.value || '').toLowerCase();
            const s = (document.getElementById('filterSearch')?.value || '').toLowerCase();

            document.querySelectorAll('#dataTable tbody tr').forEach(r => {
                const c = r.getElementsByTagName('td');
                if (c.length < 7) return;
                r.style.display = (
                    (!u || (c[0].textContent || '').toLowerCase().includes(u)) &&
                    (!st || (c[5].textContent || '').toLowerCase().includes(st)) &&
                    (!rg || (c[1].textContent || '').toLowerCase().includes(rg)) &&
                    (!s || (r.textContent || '').toLowerCase().includes(s))
                ) ? '' : 'none';
            });
        }

        function resetFilters() {
            ['filterUser', 'filterStatus', 'filterRegion'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = '';
            });
            const s = document.getElementById('filterSearch');
            if (s) s.value = '';
            filterTable();
        }
    </script>
@endsection
