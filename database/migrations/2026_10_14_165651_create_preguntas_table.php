<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('factor_id')
                ->constrained('factores')
                ->cascadeOnDelete();

            $table->foreignId('tema_id')
                ->nullable()
                ->constrained('temas')
                ->nullOnDelete();
            // Indica si la pregunta calcula NPS
            $table->boolean('es_nps')->default(false);

            $table->text('texto');

            $table->boolean('activo')->default(true);

           /* $table->foreignId('tipo_respuesta_id')
                ->nullable()
                ->constrained('tipos_respuesta')
                ->restrictOnDelete(); */
                
            /*$table->foreignId('escala_id')
                ->nullable()
                ->constrained('escalas')
                ->restrictOnDelete();*/

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
