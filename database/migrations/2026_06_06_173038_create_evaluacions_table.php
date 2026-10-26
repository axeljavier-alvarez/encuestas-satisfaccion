<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empleado_evaluador_id')
                ->constrained('empleados')
                ->restrictOnDelete();

            $table->foreignId('empleado_evaluado_id')
                ->constrained('empleados')
                ->restrictOnDelete();

            $table->foreignId('plantilla_id')
                ->constrained('plantillas')
                ->restrictOnDelete();

            $table->string('estado', 20)->default('pendiente');
            $table->timestamp('fecha_finalizacion')->nullable();

            $table->timestamps();

            $table->unique(
                ['empleado_evaluador_id', 'empleado_evaluado_id'],
                'evaluacion_empleados_unica'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
