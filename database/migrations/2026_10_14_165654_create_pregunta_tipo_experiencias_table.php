<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregunta_tipo_experiencia', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pregunta_id')
                ->constrained('preguntas')
                ->cascadeOnDelete();

            $table->foreignId('tipo_experiencia_id')
                ->constrained('tipos_experiencia')
                ->restrictOnDelete();

            $table->text('texto');

            $table->unique([
                'pregunta_id',
                'tipo_experiencia_id'
            ]);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregunta_tipo_experiencia');
    }
};