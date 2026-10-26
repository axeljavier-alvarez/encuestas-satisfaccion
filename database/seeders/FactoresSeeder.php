<?php

namespace Database\Seeders;

use App\Models\Factor;
use Illuminate\Database\Seeder;

class FactoresSeeder extends Seeder
{
    public function run(): void
    {
        $factores = [
            'Recomendación',
            'Atribución institucional',
            'Difusión y acceso',
            'Vinculación municipal',
            'Atención y acompañamiento',
            'Calidad del servicio o contenido',
            'Condiciones de prestación',
            'Utilidad y resultados',
            'Mejoras y necesidades futuras',
            'Incidencias e integridad',
        ];

        foreach ($factores as $nombre) {

            Factor::updateOrCreate(
                [
                    'nombre' => $nombre,
                ],
                [
                    'activo' => true,
                ]
            );
        }
    }
}