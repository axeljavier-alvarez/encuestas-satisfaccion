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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
            ->unique()
            ->constrained('users')
            ->cascadeOnDelete();

            $table->foreignId('puesto_id')
                ->constrained('puestos')
                ->restrictOnDelete();

            $table->foreignId('jefe_id')
                ->nullable()
                ->constrained('empleados')
                ->nullOnDelete();

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
