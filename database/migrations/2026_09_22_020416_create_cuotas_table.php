<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id('id_cuota');
            $table->foreignId('id_credito')
                  ->constrained('creditos', 'id_credito')
                  ->cascadeOnDelete();
            $table->unsignedInteger('numero');
            $table->decimal('monto_total', 14, 2);
            $table->decimal('monto_pagado', 14, 2)->default(0);
            $table->date('fecha_vencimiento');
            $table->boolean('pagada')->default(false);
            $table->timestamp('fecha_pago')->nullable();
            $table->boolean('en_mora')->default(false);
            $table->unsignedInteger('dias_mora')->default(0);
            $table->decimal('monto_mora', 14, 2)->default(0);
            $table->timestamps();

            $table->index('fecha_vencimiento');
            $table->index('pagada');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};