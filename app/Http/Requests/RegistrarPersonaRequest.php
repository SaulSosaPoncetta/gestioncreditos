<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarPersonaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres' => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'dni' => ['required', 'string', 'max:8', 'unique:personas,dni'],
            'nro_de_tramite' => ['required', 'string', 'max:11', 'unique:personas,nro_de_tramite'],
            'telefono' => ['required', 'string', 'max:11'],
            'direccion' => ['required', 'string', 'max:150'],
            'nro_direccion' => ['required', 'string', 'max:10'],
            'piso' => ['nullable', 'string', 'max:10'],
            'dpto' => ['nullable', 'string', 'max:50'],
            'correo_electronico' => ['required', 'email', 'max:150', 'unique:personas,correo_electronico'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sueldo' => ['required', 'numeric', 'min:0'],
            'foto_dni_frente' => ['required', 'image', 'max:4096'],
            'foto_dni_dorso' => ['required', 'image', 'max:4096'],
            'foto_selfie_dni_en_mano' => ['required', 'image', 'max:4096'],
            'foto_recibo_sueldo' => ['required', 'image', 'max:4096'],
        ];
    }

    public function messages(): array
    {
        return [
            'dni.unique' => 'Ya existe una persona registrada con ese DNI.',
            'nro_de_tramite.unique' => 'Ese número de trámite ya está registrado.',
            'correo_electronico.unique' => 'Ese correo ya está registrado.',
        ];
    }
}