<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('data:predictions')->twiceDaily(1, 13);
        $schedule->command('data:ndbc')->everyTenMinutes();
        $schedule->command('data:tides')->monthlyOn(24, '00:00');
        $schedule->command('data:weather')->hourly(0);

        $schedule->command('db:clean')->weekly();

        $schedule->command('backup:clean')->daily();
        $schedule->command('backup:run')->daily();
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
