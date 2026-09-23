<x-app-layout>
<div class="container py-5" style="max-width: 420px;">
    <h3 class="mb-4 text-center">Recuperar contraseña</h3>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="correo_electronico" class="form-control" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary w-100">Enviar instrucciones</button>
    </form>
</div>
</x-app-layout>