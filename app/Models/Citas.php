<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    protected $fillable = ['cliente_id', 'servicio_id', 'estado_id', 'fecha_hora'];
}
