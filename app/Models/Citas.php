<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $fillable = [
        'cliente_id',
        'servicio_id',
        'estado_id',
        'horario_id',
        'cliente_nombre',
        'servicio_nombre',
        'estado_nombre',
        'fecha_hora',
    ];
    
}
