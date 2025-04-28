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
        'vehiculo_id',
    ];

    // En App\Models\Citas.phpclear

public function horario()
{
    return $this->belongsTo(Horarios::class);
}
public function cliente()
{
    return $this->belongsTo(Clientes::class, 'cliente_id');
}
public function vehiculo()
{
    return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
}


    
}
