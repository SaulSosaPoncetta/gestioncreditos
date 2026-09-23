<?php

namespace App\Http\Controllers;

use App\Http\Requests\SolicitarCreditoRequest;
use App\Models\Credito;
use Illuminate\Support\Facades\Auth;

class CreditoController extends Controller
{
    public function showFormulario()
    {
        $persona = Auth::guard('persona')->user();

        if ($persona->estado_solicitud !== 'Aprobado') {
            return redirect()->route('panel.index')
                ->with('status', 'Tu cuenta todavía no fue aprobada como cliente. No podés solicitar créditos.');
        }

        return view('credito.solicitar', [
            'tiposInteres' => Credito::INTERES,
        ]);
    }

    public function calcularSimulacion(SolicitarCreditoRequest $request)
    {
        [$montoTotal, $montoCuota] = $this->calcular(
            $request->tipo_credito,
            $request->monto_solicitado,
            $request->cantidad_cuotas
        );

        return response()->json([
            'interes' => Credito::INTERES[$request->tipo_credito] * 100,
            'monto_total' => round($montoTotal, 2),
            'monto_cuota' => round($montoCuota, 2),
        ]);
    }

    public function solicitar(SolicitarCreditoRequest $request)
    {
        $persona = Auth::guard('persona')->user();

        if ($persona->estado_solicitud !== 'Aprobado') {
            return back()->withErrors(['tipo_credito' => 'Tu cuenta todavía no fue aprobada como cliente.']);
        }

        $credito = Credito::create([
            'id_persona' => $persona->id_persona,
            'tipo_credito' => $request->tipo_credito,
            'monto_solicitado' => $request->monto_solicitado,
            'cantidad_cuotas' => $request->cantidad_cuotas,
            'fecha_solicitud' => now(),
            'estado_credito' => Credito::ESTADO_PENDIENTE,
        ]);

        return redirect()->route('panel.index')
            ->with('status', "Solicitud de crédito #{$credito->id_credito} enviada. Está pendiente de aprobación.");
    }

    private function calcular(string $tipo, float $monto, int $cuotas): array
    {
        $interes = Credito::INTERES[$tipo];
        $montoTotal = $monto * (1 + $interes);
        $montoCuota = $montoTotal / $cuotas;

        return [$montoTotal, $montoCuota];
    }
}