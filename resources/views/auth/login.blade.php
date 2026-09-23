<x-app-layout>
<div class="container py-5" style="max-width: 420px;">
    <h3 class="mb-4 text-center">Iniciar sesión</h3>

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo_electronico" class="form-control" value="{{ old('correo_electronico') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        <div class="text-center mt-3">
            <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
        </div>
    </form>
</div>
</x-app-layout>