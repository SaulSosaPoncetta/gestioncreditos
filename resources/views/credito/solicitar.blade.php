<x-app-layout>
<div class="container py-5" style="max-width: 560px;">
    <h3 class="mb-4">Solicitar crédito</h3>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('credito.guardar') }}" id="formCredito">
        @csrf
        <div class="mb-3">
            <label class="form-label">Tipo de crédito</label>
            <select name="tipo_credito" id="tipo_credito" class="form-select" required>
                @foreach ($tiposInteres as $tipo => $interes)
                    <option value="{{ $tipo }}">{{ $tipo }} ({{ $interes * 100 }}% interés)</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Monto solicitado</label>
            <input type="number" step="0.01" name="monto_solicitado" id="monto_solicitado" class="form-control" min="1000" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Cantidad de cuotas</label>
            <input type="number" name="cantidad_cuotas" id="cantidad_cuotas" class="form-control" min="1" max="60" required>
        </div>

        <div class="card bg-light mb-3">
            <div class="card-body">
                <p class="mb-1">Monto total a pagar: <strong id="montoTotal">-</strong></p>
                <p class="mb-0">Valor de cada cuota: <strong id="montoCuota">-</strong></p>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Confirmar solicitud</button>
    </form>
</div>

<script>
function simular() {
    const tipo = document.getElementById('tipo_credito').value;
    const monto = document.getElementById('monto_solicitado').value;
    const cuotas = document.getElementById('cantidad_cuotas').value;

    if (!monto || !cuotas) return;

    fetch('{{ route('credito.simular') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            tipo_credito: tipo,
            monto_solicitado: monto,
            cantidad_cuotas: cuotas,
        }),
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('montoTotal').textContent = '$' + data.monto_total;
        document.getElementById('montoCuota').textContent = '$' + data.monto_cuota;
    });
}

['tipo_credito', 'monto_solicitado', 'cantidad_cuotas'].forEach(id => {
    document.getElementById(id).addEventListener('input', simular);
    document.getElementById(id).addEventListener('change', simular);
});
</script>
</x-app-layout>