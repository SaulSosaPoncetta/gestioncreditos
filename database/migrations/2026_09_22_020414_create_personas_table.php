<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('dni', 8)->unique();
            $table->string('nro_de_tramite', 11)->unique();
            $table->string('telefono', 11);
            $table->string('direccion', 150);
            $table->string('nro_direccion', 10);
            $table->string('piso', 10)->nullable();
            $table->string('dpto', 50)->nullable();
            $table->string('correo_electronico', 150)->unique();
            $table->string('contrasenia', 255);
            $table->string('foto_dni_frente', 500)->nullable();
            $table->string('foto_dni_dorso', 500)->nullable();
            $table->string('foto_selfie_dni_en_mano', 500)->nullable();
            $table->string('foto_recibo_sueldo', 500)->nullable();
            $table->boolean('cliente')->default(false);
            $table->boolean('creditos_activos')->default(false);
            $table->boolean('estado_postulante')->default(true);
            $table->string('estado_cuenta_cliente', 20)->default('Al día');
            $table->decimal('sueldo', 10, 2);
            $table->string('motivo_rechazo', 255)->nullable();
            $table->text('mensaje_rechazo')->nullable();
            $table->enum('estado_solicitud', ['Evaluación', 'Pendiente', 'Aprobado', 'Rechazado'])
                  ->default('Evaluación');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};