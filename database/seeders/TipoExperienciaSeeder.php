<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoExperiencia;

class TipoExperienciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $tiposExperiencia = [
            'Servicio',
            'Actividad',
            'Curso',
            'Taller',
            'Programa',
            'Iniciativa',
            'Conferencia',
            'Evento',
        ];

        foreach ($tiposExperiencia as $nombre){
            TipoExperiencia::firstOrCreate(
                ['nombre' => $nombre],
                ['activo' => true]
            );
        }

    }
}
