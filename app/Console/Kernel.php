<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Console\Application as Artisan;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Backup ko hourly run karna
        $schedule->command('data:transfer-all')->hourly();
    }

    protected function commands(): void
    {
        require base_path('routes/console.php');
    }
}
