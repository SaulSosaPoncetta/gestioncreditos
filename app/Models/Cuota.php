<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    protected $table = 'cuotas';
    protected $primaryKey = 'id_cuota';

    protected $fillable = [
        'id_credito',
        'numero',
        'monto_total',
        'monto_pagado',
        'fecha_vencimiento',
        'pagada',
        'fecha_pago',
        'en_mora',
        'dias_mora',
        'monto_mora',
    ];

    protected function casts(): array
    {
        return [
            'monto_total' => 'decimal:2',
            'monto_pagado' => 'decimal:2',
            'monto_mora' => 'decimal:2',
            'fecha_vencimiento' => 'date',
            'fecha_pago' => 'datetime',
            'pagada' => 'boolean',
            'en_mora' => 'boolean',
        ];
    }

    public function credito()
    {
        return $this->belongsTo(Credito::class, 'id_credito', 'id_credito');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_cuota', 'id_cuota');
    }
}