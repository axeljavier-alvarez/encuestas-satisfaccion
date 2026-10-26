<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preguntas', function (Blueprint $table) {
            $table->string('codigo', 20)->nullable()->unique();
            $table->boolean('obligatoria')->default(false);
        });
        Schema::table('opciones_respuesta', function (Blueprint $table) {
            $table->boolean('es_excluyente')->default(false);
            $table->boolean('habilita_texto')->default(false);
            $table->string('etiqueta_texto_adicional', 150)->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('opciones_respuesta', function (Blueprint $table) {
            $table->dropColumn(['es_excluyente', 'habilita_texto', 'etiqueta_texto_adicional']);
        });
        Schema::table('preguntas', function (Blueprint $table) {
            $table->dropColumn(['codigo', 'obligatoria',
             
                ]);
        });
    }
};
