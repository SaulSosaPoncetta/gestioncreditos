<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->foreignId('id_cuota')
                  ->nullable()
                  ->constrained('cuotas', 'id_cuota')
                  ->nullOnDelete();
            $table->foreignId('id_persona')
                  ->constrained('personas', 'id_persona')
                  ->cascadeOnDelete();
            $table->foreignId('id_credito')
                  ->constrained('creditos', 'id_credito')
                  ->cascadeOnDelete();
            $table->decimal('monto_cuota', 12, 2);
            $table->decimal('monto_mora', 10, 2)->default(0);
            $table->timestamp('fecha_pago')->useCurrent();
            $table->string('mensaje', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};