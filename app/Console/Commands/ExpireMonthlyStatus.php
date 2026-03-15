<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Collection;
use App\Models\ScallingImport;
use App\Models\RisingStar;

class ExpireMonthlyStatus extends Command
{
    protected $signature   = 'app:expire-monthly-status';
    protected $description = 'Set status inactive untuk data yang periodenya sudah lewat bulan berjalan';

    public function handle()
    {
        // Periode bulan lalu dalam format Y-m-d (karena di DB disimpan sebagai 2026-03-01)
        $lastMonth   = Carbon::now()->subMonth();
        $periodeDate = $lastMonth->format('Y-m') . '-01';
        $label       = $lastMonth->format('F Y');

        $this->info("Memproses expiry untuk periode: {$label}");

        DB::transaction(function () use ($periodeDate, $label) {

            // ── Collection ──────────────────────────────────────────
            $collectionCount = Collection::where('periode', $periodeDate)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);
            // is_latest TIDAK disentuh

            // ── ScallingImport ───────────────────────────────────────
            $scallingCount = ScallingImport::where('periode', $periodeDate)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);

            // ── RisingStar ───────────────────────────────────────────
            // Sesuaikan nama kolom periode di tabel rising_stars jika berbeda
            $risingCount = RisingStar::where('periode', $periodeDate)
                ->where('status', 'active')
                ->update(['status' => 'inactive']);

            $this->info("Collection  : {$collectionCount} record dinonaktifkan");
            $this->info("ScallingImport: {$scallingCount} record dinonaktifkan");
            $this->info("RisingStar  : {$risingCount} record dinonaktifkan");

            Log::info('ExpireMonthlyStatus selesai', [
                'periode'        => $periodeDate,
                'collection'     => $collectionCount,
                'scalling_import' => $scallingCount,
                'rising_star'    => $risingCount,
            ]);
        });

        $this->info('Selesai.');
        return Command::SUCCESS;
    }
}