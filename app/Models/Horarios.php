<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horarios extends Model
{
    protected $fillable = ['fecha_hora', 'servicio_id'];
}
