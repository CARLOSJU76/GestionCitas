<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- esto es lo importante
use Illuminate\Notifications\Notifiable;

class Clientes extends Authenticatable
{

    use HasFactory, Notifiable;
    protected $table = 'clientes'; // tu tabla

    
    protected $fillable = ['nombre','identificacion', 'email', 'telefono', 'password', 'perfil_id'];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getAuthIdentifierName()
    {
        return 'email';  // El identificador que utilizamos para autenticar (usualmente 'email')
    }
    public function getAuthPassword()
    {
        return $this->password;  // Retorna la contraseña encriptada del cliente
    }
    public function getRememberToken()
    {
        return $this->remember_token;  // Token de recordar usuario
    }
    public function setRememberToken($value)
    {
        $this->remember_token = $value;  // Establecer el token
    }
    public function getRememberTokenName()
    {
        return 'remember_token';  // Nombre del campo de token de "recordar"
    }

    public function perfil()
{
    return $this->belongsTo(Perfil::class, 'perfil_id');
}

}
