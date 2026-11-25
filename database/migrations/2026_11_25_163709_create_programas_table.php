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
        Schema::create('programas', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();

            $table->foreignId('dependencia_id')
                ->constrained('dependencias')
                ->cascadeOnDelete();

            $table->string('nombre', 255);
            $table->char('estado', 1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
