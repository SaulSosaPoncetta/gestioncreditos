<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;

    protected $table = 'personas';
    protected $primaryKey = 'id_persona';

    const ESTADO_EVALUACION = 'Evaluación';
    const ESTADO_PENDIENTE  = 'Pendiente';
    const ESTADO_APROBADO   = 'Aprobado';
    const ESTADO_RECHAZADO  = 'Rechazado';

    protected $fillable = [
        'nombres',
        'apellidos',
        'dni',
        'nro_de_tramite',
        'telefono',
        'direccion',
        'nro_direccion',
        'piso',
        'dpto',
        'correo_electronico',
        'contrasenia',
        'foto_dni_frente',
        'foto_dni_dorso',
        'foto_selfie_dni_en_mano',
        'foto_recibo_sueldo',
        'cliente',
        'creditos_activos',
        'estado_postulante',
        'estado_cuenta_cliente',
        'sueldo',
        'motivo_rechazo',
        'mensaje_rechazo',
        'estado_solicitud',
    ];

    protected $hidden = [
        'contrasenia',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->contrasenia;
    }

    protected function casts(): array
    {
        return [
            'contrasenia' => 'hashed',
            'cliente' => 'boolean',
            'creditos_activos' => 'boolean',
            'estado_postulante' => 'boolean',
            'sueldo' => 'decimal:2',
        ];
    }

    public function creditos()
    {
        return $this->hasMany(Credito::class, 'id_persona', 'id_persona');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_persona', 'id_persona');
    }
        public function getEmailForPasswordReset()
    {
        return $this->correo_electronico;
    }
}