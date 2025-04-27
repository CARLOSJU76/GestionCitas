<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $fillable = ['nombre','identificacion', 'email', 'telefono', 'password', 'perfil_id'];
    public function perfil()
{
    return $this->belongsTo(Perfil::class, 'perfil_id');
}

}
