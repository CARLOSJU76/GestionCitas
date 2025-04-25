<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

// Importa tu comando personalizado
use App\Console\Commands\EliminarHorariosCaducados;

class Kernel extends ConsoleKernel
{
    /**
     * Define los comandos personalizados que pueden ejecutarse vía Artisan.
     */
    protected $commands = [
        EliminarHorariosCaducados::class, // Registro del comando
    ];

    /**
     * Define la programación de tareas (cron jobs).
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecutar el comando todos los días a medianoche
        $schedule->command('horarios:borrar-caducados')->daily();
    }

    /**
     * Registrar los archivos de comandos.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
