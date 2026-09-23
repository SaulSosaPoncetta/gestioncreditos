<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('creditos', function (Blueprint $table) {
            $table->id('id_credito');
            $table->foreignId('id_persona')
                  ->constrained('personas', 'id_persona')
                  ->cascadeOnDelete();
            $table->enum('tipo_credito', ['Personal', 'PyME', 'Automotor']);
            $table->decimal('monto_solicitado', 12, 2);
            $table->unsignedInteger('cantidad_cuotas');
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->enum('estado_credito', ['Pendiente', 'Aprobado', 'Activo', 'Rechazado', 'Finalizado', 'En mora'])
                  ->default('Pendiente');
            $table->timestamps();

            $table->index('estado_credito');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('creditos');
    }
};