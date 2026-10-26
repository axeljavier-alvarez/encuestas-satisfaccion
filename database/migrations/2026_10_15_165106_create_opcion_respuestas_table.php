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
        Schema::create('opciones_respuesta', function (Blueprint $table) {
            $table->id();

            /*$table->foreignId('pregunta_id')
                ->constrained('preguntas')
                ->cascadeOnDelete(); */
            $table->foreignId('pregunta_tipo_respuesta_id')
                ->constrained('pregunta_tipo_respuesta')
                ->cascadeOnDelete();

            $table->string('valor', 50);
            $table->string('etiqueta', 100);

            $table->timestamps();

            $table->unique(['pregunta_tipo_respuesta_id', 'valor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('opciones_respuesta');
    }
};
