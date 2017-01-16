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
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
	 * file:///htdocs/laravel/docs/laravel.5.0.docs/docs/5.0/artisan.html
	 * $schedule->command('foo')->cron('* * * * *');
	 * $schedule->command('foo')->everyFiveMinutes();
	 * $schedule->command('foo')->daily();
	 * ->dailyAt('15:00')
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
    }
}
