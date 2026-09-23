<?php

namespace App\Http\Requests;

use App\Models\Credito;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SolicitarCreditoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_credito' => ['required', Rule::in(array_keys(Credito::INTERES))],
            'monto_solicitado' => ['required', 'numeric', 'min:1000'],
            'cantidad_cuotas' => ['required', 'integer', 'min:1', 'max:60'],
        ];
    }
}