<?php

namespace App\Console;

use App\Jobs\FetchHosts;
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
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        foreach ($this->getOptions() as $option) {
            $schedule->job(new FetchHosts($option))->everyMinute()
                ->withoutOverlapping();
        }
    }

    private function getOptions(): array
    {
        return [
            'default',
            'fakenews',
            'gambling',
            'porn',
            'social',
            'fakenews-gambling',
            'fakenews-porn',
            'fakenews-social',
            'gambling-porn',
            'gambling-social',
            'porn-social',
            'fakenews-gambling-porn',
            'fakenews-gambling-social',
            'fakenews-porn-social',
            'gambling-porn-social',
            'fakenews-gambling-porn-social'
        ];
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
