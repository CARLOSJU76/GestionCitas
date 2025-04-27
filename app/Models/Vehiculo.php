<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'placa',
        'cliente_id',
    ];

    /**
     * Relación: Un Vehiculo pertenece a un Cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }
}
