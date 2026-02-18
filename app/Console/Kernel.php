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
        //$schedule->command('grade:betslips')->hourly();
        //after 1PM game(s) in UTC
        $schedule->command('insert:nflscores')->cron('15 20 * * 7');
        $schedule->command('grade:pickem')->cron('20 20 * * 7');
        //$schedule->command('grade:survivor')->cron('20 20 * * 7');
        //after 4PM game(s) in UTC
        $schedule->command('insert:nflscores')->cron('0 1 * * 1');
        $schedule->command('grade:pickem')->cron('5 1 * * 1');
        //$schedule->command('grade:survivor')->cron('5 1 * * 1');
        //after SNF game(s) in UTC
        $schedule->command('insert:nflscores')->cron('0 5 * * 1');
        $schedule->command('grade:pickem')->cron('5 5 * * 1');
        //$schedule->command('grade:survivor')->cron('5 5 * * 1');
        //after MNF game(s) in UTC
        $schedule->command('insert:nflscores')->cron('0 5 * * 2');
        $schedule->command('grade:pickem')->cron('5 5 * * 2');
        //$schedule->command('grade:survivor')->cron('5 5 * * 2');
        //after TNF game(s) in UTC
        $schedule->command('insert:nflscores')->cron('0 5 * * 5');
        $schedule->command('grade:pickem')->cron('5 5 * * 5');
        //$schedule->command('grade:survivor')->cron('5 5 * * 5');
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
