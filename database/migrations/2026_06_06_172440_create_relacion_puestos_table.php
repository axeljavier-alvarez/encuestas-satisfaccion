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
        Schema::create('relaciones_puestos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('puesto_evaluador_id')
                ->constrained('puestos')
                ->restrictOnDelete();

            $table->foreignId('puesto_evaluado_id')
                ->constrained('puestos')
                ->restrictOnDelete();

            $table->boolean('activo')->default(true);

            $table->timestamps();

            $table->unique(
                ['puesto_evaluador_id', 'puesto_evaluado_id'],
                'relacion_puestos_unica'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relaciones_puestos');
    }
};
