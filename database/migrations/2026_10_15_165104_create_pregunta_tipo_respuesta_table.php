
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pregunta_tipo_respuesta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregunta_id')
                ->constrained('preguntas')
                ->cascadeOnDelete();
            $table->foreignId('tipo_respuesta_id')
                ->constrained('tipos_respuesta')
                ->restrictOnDelete();
            $table->foreignId('escala_id')
                ->nullable()
                ->constrained('escalas')
                ->restrictOnDelete();
            $table->timestamps();

            $table->unique([
                'pregunta_id',
                'tipo_respuesta_id'
            ], 'pregunta_tipo_unico');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pregunta_tipo_respuesta');
    }
};
