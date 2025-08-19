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
        // Vérification des rappels de tâches
        $schedule->command('rappels:verifier')
                 ->everyMinute()
                 ->withoutOverlapping() // Empêche l'exécution multiple si la précédente dure trop longtemps
                 ->onOneServer() // Pour les applications multi-serveurs
                 ->appendOutputTo(storage_path('logs/rappels.log')); // Journalisation
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