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
        // $schedule->command('appointment:generate-weekly')
        //     ->weeklyOn(5, '06:00')
        //     ->appendOutputTo('scheduler.log');
        $schedule->command('appointment:generate-weekly')
            ->everyTwoMinutes()
            ->appendOutputTo('scheduler.log');
    }
    public function scheduleTimeZone()
    {
        return 'Asia/Tehran';
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
