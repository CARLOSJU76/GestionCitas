<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $fillable = ['fecha_hora', 'servicio_id'];
    public function servicio()
    {
        return $this->belongsTo(Servicios::class, 'servicio_id');
    }
}
