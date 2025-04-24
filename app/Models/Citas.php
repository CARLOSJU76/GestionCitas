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

    // En App\Models\Citas.php
public function horario()
{
    return $this->belongsTo(Horarios::class);
}
public function cliente()
{
    return $this->belongsTo(Clientes::class, 'cliente_id');
}

    
}
