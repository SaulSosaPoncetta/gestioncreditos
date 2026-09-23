<x-app-layout>
<div class="container py-5" style="max-width: 420px;">
    <h3 class="mb-4 text-center">Restablecer contraseña</h3>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo_electronico" class="form-control" value="{{ $correo_electronico }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Actualizar contraseña</button>
    </form>
</div>
</x-app-layout>