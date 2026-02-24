@extends('layouts.app')

@section('title', 'SOE - PSAK')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <a href="{{ route('soe.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 mb-2 inline-block flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                    <h1 class="text-4xl font-bold text-gray-900 mb-2">📋 PSAK - Penyisihan Kerugian Aset</h1>
                    <p class="text-gray-600 text-lg">Input data PSAK untuk tanggal {{ now()->format('d F Y') }}</p>
                </div>
            </div>
            <div class="h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full"></div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">✓ Data PSAK berhasil disimpan!</span>
        </div>

        <!-- PSAK Form -->
        <form id="psakForm" class="space-y-6">
            @csrf
            
            <!-- SSL Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">SSL</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Commitment (SSL)</label>
                        <input type="text" name="commitment_ssl" value="{{ $psak->commitment_ssl ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Real (SSL)</label>
                        <input type="text" name="real_ssl" value="{{ $psak->real_ssl ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Rupiah (Rp) Section -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-200">
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Rupiah (Rp)</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Commitment (Rp)</label>
                        <input type="text" name="commitment_rp" value="{{ $psak->commitment_rp ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Real (Rp)</label>
                        <input type="text" name="real_rp" value="{{ $psak->real_rp ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                    💾 Simpan Data PSAK
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Handle form submission
    $('#psakForm').on('submit', function(e) {
        e.preventDefault();
        savePsakData();
    });

    function savePsakData() {
        const formData = new FormData($('#psakForm')[0]);
        
        $.ajax({
            url: '{{ route("soe.psak.save") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message
                $('#successMessage').removeClass('hidden');
                setTimeout(function() {
                    $('#successMessage').addClass('hidden');
                }, 3000);
                
                // You can also use Swal if available
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data PSAK berhasil disimpan!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menyimpan data!'
                    });
                } else {
                    alert('Terjadi kesalahan saat menyimpan data!');
                }
            }
        });
    }
});
</script>
@endsection
