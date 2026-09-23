<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Administrador extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $table = 'administradores';
    protected $primaryKey = 'id_administrador';

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo_electronico',
        'contrasenia',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    // Laravel espera "password" para el hashing/auth; mapeamos al campo real
    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    protected function casts(): array
    {
        return [
            'contrasenia' => 'hashed',
        ];
    }

    public function notificaciones()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }
        public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }
}