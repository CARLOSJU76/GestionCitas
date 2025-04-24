<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Horarios;
use Carbon\Carbon;

class BorrarHorariosCaducados extends Command
{
    protected $signature = 'horarios:borrar-caducados';
    protected $description = 'Borra todos los horarios que ya han caducado';

    public function handle()
    {
        $hoy = Carbon::now();

        $eliminados = Horarios::where('fecha_hora', '<', $hoy)->delete();

        $this->info("Se eliminaron $eliminados horarios caducados.");
    }
}
