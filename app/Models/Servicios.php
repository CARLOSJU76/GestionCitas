<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $fillable = ['nombre', 'precio'];
    public function horarios()
    {
        return $this->hasMany(Horarios::class, 'servicio_id');
    }
}
