<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       // $schedule->command('carinspectionsnotify:cron')->everyMinute();
        //$schedule->command('seyyursefernotify:cron')->everyMinute();
        $schedule->command('carinspectionsnotify:cron')->dailyAt('08:00');
        $schedule->command('seyyursefernotify:cron')->dailyAt('08:00');
//        $schedule->command('reservationendsreminder:cron')->dailyAt('08:00');
//        $schedule->command('model:prune')->everyMinute();
   }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
