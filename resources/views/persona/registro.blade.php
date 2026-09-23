<x-app-layout>
<div class="container py-5" style="max-width: 640px;">
    <h3 class="mb-4">Registro de postulante</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('persona.registrar') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" value="{{ old('dni') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">N° de trámite</label>
                <input type="text" name="nro_de_tramite" class="form-control" value="{{ old('nro_de_tramite') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Sueldo</label>
                <input type="number" step="0.01" name="sueldo" class="form-control" value="{{ old('sueldo') }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">N° dirección</label>
                <input type="text" name="nro_direccion" class="form-control" value="{{ old('nro_direccion') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Piso (opcional)</label>
                <input type="text" name="piso" class="form-control" value="{{ old('piso') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Depto (opcional)</label>
                <input type="text" name="dpto" class="form-control" value="{{ old('dpto') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>
                <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" required>
                <button type="button" id="btnEnviarCodigo" class="btn btn-sm btn-outline-secondary mt-2">Enviar código de verificación</button>
                <div class="input-group mt-2">
                    <input type="text" id="codigoInput" class="form-control" placeholder="Código de 6 dígitos">
                    <button type="button" id="btnVerificarCodigo" class="btn btn-outline-primary">Verificar</button>
                </div>
                <div id="estadoVerificacion" class="form-text"></div>
            </div>
            <div class="col-md-6">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Foto DNI (frente)</label>
                <input type="file" name="foto_dni_frente" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Foto DNI (dorso)</label>
                <input type="file" name="foto_dni_dorso" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Selfie con DNI en mano</label>
                <input type="file" name="foto_selfie_dni_en_mano" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Recibo de sueldo</label>
                <input type="file" name="foto_recibo_sueldo" class="form-control" accept="image/*" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100 mt-4">Enviar solicitud</button>
    </form>
</div>

<script>
document.getElementById('btnEnviarCodigo').addEventListener('click', function () {
    const correo = document.getElementById('correo_electronico').value;
    fetch('{{ route('verificacion.enviar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ correo_electronico: correo }),
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('estadoVerificacion').textContent = data.mensaje;
    });
});

document.getElementById('btnVerificarCodigo').addEventListener('click', function () {
    const correo = document.getElementById('correo_electronico').value;
    const codigo = document.getElementById('codigoInput').value;
    fetch('{{ route('verificacion.verificar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({ correo_electronico: correo, codigo: codigo }),
    })
    .then(r => r.json())
    .then(data => {
        document.getElementById('estadoVerificacion').textContent = data.mensaje;
        document.getElementById('estadoVerificacion').className = data.verificado ? 'text-success' : 'text-danger';
    });
});
</script>
</x-app-layout>