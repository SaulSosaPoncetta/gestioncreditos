<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';

    protected $fillable = [
        'id_cuota',
        'id_persona',
        'id_credito',
        'monto_cuota',
        'monto_mora',
        'fecha_pago',
        'mensaje',
    ];

    protected function casts(): array
    {
        return [
            'monto_cuota' => 'decimal:2',
            'monto_mora' => 'decimal:2',
            'fecha_pago' => 'datetime',
        ];
    }

    public function cuota()
    {
        return $this->belongsTo(Cuota::class, 'id_cuota', 'id_cuota');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    public function credito()
    {
        return $this->belongsTo(Credito::class, 'id_credito', 'id_credito');
    }
}