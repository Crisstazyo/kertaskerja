<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // Jalan setiap tanggal 1 pukul 00:05
        // Pakai 00:05 bukan 00:00 untuk beri jeda jika ada proses lain di tengah malam
        $schedule->command('app:expire-monthly-status')
                ->monthlyOn(1, '00:05')
                ->withoutOverlapping()   // cegah jalan dobel jika proses sebelumnya belum selesai
                ->appendOutputTo(storage_path('logs/expire-status.log')); // log output ke file
    }
    

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
