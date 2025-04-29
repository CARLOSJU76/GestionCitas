<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCitas extends Model
{
    protected $fillable = [
        'cita_id',
        'cliente_nombre',
        'identificacion',
        'servicio_nombre',
        'estado_nombre',
        'fecha_hora',
        'vehiculo',
    ];
    
}
