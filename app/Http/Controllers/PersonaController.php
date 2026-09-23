<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarPersonaRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonaController extends Controller
{
    public function showRegistroForm()
    {
        return view('persona.registro');
    }

    public function registrar(RegistrarPersonaRequest $request)
    {
        $correoVerificado = $request->session()
            ->pull('correo_verificado_' . $request->correo_electronico, false);

        if (!$correoVerificado) {
            return back()
                ->withErrors(['correo_electronico' => 'Debés verificar tu correo antes de continuar.'])
                ->withInput();
        }

        $rutas = [];
        foreach (['foto_dni_frente', 'foto_dni_dorso', 'foto_selfie_dni_en_mano', 'foto_recibo_sueldo'] as $campo) {
            $rutas[$campo] = $request->file($campo)->store('personas/documentos', 'public');
        }

        $persona = Persona::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dni' => $request->dni,
            'nro_de_tramite' => $request->nro_de_tramite,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'nro_direccion' => $request->nro_direccion,
            'piso' => $request->piso,
            'dpto' => $request->dpto,
            'correo_electronico' => $request->correo_electronico,
            'contrasenia' => $request->password,
            'sueldo' => $request->sueldo,
            'estado_solicitud' => Persona::ESTADO_EVALUACION,
            ...$rutas,
        ]);

        Auth::guard('persona')->login($persona);

        return redirect()->route('panel.index')
            ->with('status', 'Registro exitoso. Tu solicitud está en evaluación.');
    }
}