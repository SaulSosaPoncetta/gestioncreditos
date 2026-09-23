<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $table = 'contactos';
    protected $primaryKey = 'id_contacto';

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo_electronico',
        'asunto',
        'mensaje',
        'fecha_envio',
    ];

    protected function casts(): array
    {
        return [
            'fecha_envio' => 'datetime',
        ];
    }
}