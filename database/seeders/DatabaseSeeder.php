<?php

namespace Database\Seeders;

use App\Models\TipoRespuesta;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders principales.
     */
    public function run(): void
    {
        $this->call([
            TipoExperienciaSeeder::class,
            FactoresSeeder::class,
            TemasSeeder::class,
            EscalasSeeder::class,
            DatosInicialesSeeder::class,
            DatosOrganizacionalesSeeder::class,
            TiposRespuestaSeeder::class,
            PlantillaSeeder::class,
            DependenciaSeeder::class,
            ProgramaSeeder::class
        ]);

    }
}