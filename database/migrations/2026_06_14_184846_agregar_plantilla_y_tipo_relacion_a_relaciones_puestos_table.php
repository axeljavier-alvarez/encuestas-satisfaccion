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
        Schema::table('relaciones_puestos', function (Blueprint $table) {
            $table->foreignId('plantilla_id')
                ->nullable()
                ->after('puesto_evaluado_id')
                ->constrained('plantillas')
                ->nullOnDelete();

            $table->string('tipo_relacion', 50)
                ->nullable()
                ->after('plantilla_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('relaciones_puestos', function (Blueprint $table) {
            $table->dropForeign(['plantilla_id']);
            $table->dropColumn(['plantilla_id', 'tipo_relacion']);
        });
    }
};
