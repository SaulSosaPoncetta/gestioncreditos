<?php

namespace App\Http\Controllers;

use App\Mail\CodigoVerificacionMail;
use App\Models\CodigoVerificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerificacionController extends Controller
{
    public function enviarCodigo(Request $request)
    {
        $request->validate([
            'correo_electronico' => ['required', 'email'],
        ]);

        $codigo = (string) random_int(100000, 999999);

        CodigoVerificacion::create([
            'correo_electronico' => $request->correo_electronico,
            'codigo' => $codigo,
            'creado_en' => now(),
        ]);

        Mail::to($request->correo_electronico)->send(new CodigoVerificacionMail($codigo));

        return response()->json(['mensaje' => 'Código enviado correctamente.']);
    }

    public function verificarCodigo(Request $request)
    {
        $request->validate([
            'correo_electronico' => ['required', 'email'],
            'codigo' => ['required', 'string'],
        ]);

        $registro = CodigoVerificacion::where('correo_electronico', $request->correo_electronico)
            ->where('codigo', $request->codigo)
            ->orderByDesc('creado_en')
            ->first();

        if (!$registro) {
            return response()->json(['verificado' => false, 'mensaje' => 'Código incorrecto.'], 422);
        }

        if ($registro->creado_en->diffInMinutes(now()) > 10) {
            return response()->json(['verificado' => false, 'mensaje' => 'El código venció, solicitá uno nuevo.'], 422);
        }

        $request->session()->put('correo_verificado_' . $request->correo_electronico, true);

        return response()->json(['verificado' => true, 'mensaje' => 'Correo verificado correctamente.']);
    }
}