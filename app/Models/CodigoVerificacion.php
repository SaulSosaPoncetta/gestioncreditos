<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoVerificacion extends Model
{
    use HasFactory;

    protected $table = 'codigos_verificacion';
    public $timestamps = false;

    protected $fillable = [
        'correo_electronico',
        'codigo',
        'creado_en',
    ];

    protected function casts(): array
    {
        return [
            'creado_en' => 'datetime',
        ];
    }
}