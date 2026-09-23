<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;

    protected $table = 'creditos';
    protected $primaryKey = 'id_credito';

    const TIPO_PERSONAL  = 'Personal';
    const TIPO_PYME      = 'PyME';
    const TIPO_AUTOMOTOR = 'Automotor';

    // % de interés según tipo de crédito (igual que el sistema original)
    const INTERES = [
        self::TIPO_PERSONAL  => 0.35,
        self::TIPO_PYME      => 0.20,
        self::TIPO_AUTOMOTOR => 0.15,
    ];

    const ESTADO_PENDIENTE  = 'Pendiente';
    const ESTADO_APROBADO   = 'Aprobado';
    const ESTADO_ACTIVO     = 'Activo';
    const ESTADO_RECHAZADO  = 'Rechazado';
    const ESTADO_FINALIZADO = 'Finalizado';
    const ESTADO_EN_MORA    = 'En mora';

    protected $fillable = [
        'id_persona',
        'tipo_credito',
        'monto_solicitado',
        'cantidad_cuotas',
        'fecha_solicitud',
        'estado_credito',
    ];

    protected function casts(): array
    {
        return [
            'monto_solicitado' => 'decimal:2',
            'fecha_solicitud' => 'datetime',
        ];
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function cuotas()
    {
        return $this->hasMany(Cuota::class, 'id_credito', 'id_credito');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_credito', 'id_credito');
    }
}