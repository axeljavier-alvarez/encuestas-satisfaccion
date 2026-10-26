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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pregunta_id')
                ->constrained('preguntas')
                ->restrictOnDelete();

            $table->foreignId('opcion_respuesta_id')
                ->nullable()
                ->constrained('opciones_respuesta')
                ->restrictOnDelete();

            $table->text('respuesta_texto')->nullable();

            $table->unsignedTinyInteger('puntaje_nps')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas');
    }
};
