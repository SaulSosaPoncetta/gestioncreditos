<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\VerificacionController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\CreditoController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth:persona')->group(function () {
    Route::get('/panel', fn () => 'Panel cliente OK')->name('panel.index');

    Route::get('/creditos/solicitar', [CreditoController::class, 'showFormulario'])->name('credito.solicitar');
    Route::post('/creditos/simular', [CreditoController::class, 'calcularSimulacion'])->name('credito.simular');
    Route::post('/creditos/solicitar', [CreditoController::class, 'solicitar'])->name('credito.guardar');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Placeholders (los completamos en los módulos 6 y 11)
Route::middleware('auth:admin')->get('/admin/dashboard', fn () => 'Panel admin OK')->name('admin.dashboard');
Route::middleware('auth:persona')->get('/panel', fn () => 'Panel cliente OK')->name('panel.index');

Route::post('/verificacion/enviar', [VerificacionController::class, 'enviarCodigo'])->name('verificacion.enviar');
Route::post('/verificacion/verificar', [VerificacionController::class, 'verificarCodigo'])->name('verificacion.verificar');

Route::get('/registro', [PersonaController::class, 'showRegistroForm'])->name('persona.registro');
Route::post('/registro', [PersonaController::class, 'registrar'])->name('persona.registrar');
