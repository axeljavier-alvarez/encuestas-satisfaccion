<?php

namespace Database\Seeders;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;

class DependenciaSeeder extends Seeder
{
    public function run(): void
    {
        $dependencias = [
            [2, 'DIRECCIÓN DE SALUD Y BIENESTAR'],
            [3, 'DIRECCIÓN DE RECURSOS HUMANOS'],
            [4, 'DIRECCIÓN DE DESARROLLO SOCIAL'],
            [5, 'DIRECCIÓN DE EDUCACIÓN Y CULTURA'],
            [6, 'DIRECCIÓN MUNICIPAL DE LA MUJER'],
            [7, 'DIRECCIÓN DE COMERCIO POPULAR'],
            [8, 'SECRETARÍA DE ASUNTOS SOCIALES'],
            [21, 'UNIDAD MUNICIPAL DE EMPRENDIMIENTO'],
            [41, 'UNIDAD DE CONVIVENCIA SOCIAL'],
            [61, 'GERENCIA DESARROLLO SOCIAL'],
        ];

        foreach ($dependencias as [$id, $nombre]) {
            Dependencia::updateOrCreate(
                ['id' => $id],
                ['nombre' => $nombre]
            );
        }
    }
}