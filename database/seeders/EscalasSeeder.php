<?php

namespace Database\Seeders;

use App\Models\Escala;
use Illuminate\Database\Seeder;

class EscalasSeeder extends Seeder
{
    public function run(): void
    {
        Escala::updateOrCreate(
            ['nombre' => 'Escala NPS de 0 a 10'],
            [
                'minimo' => 0,
                'maximo' => 10,
                'permite_no_sabe' => false,
                'permite_no_aplica' => false,
            ]
        );

        Escala::updateOrCreate(
            ['nombre' => 'Escala general de 0 a 10'],
            [
                'minimo' => 0,
                'maximo' => 10,
                'permite_no_sabe' => true,
                'permite_no_aplica' => true,
            ]
        );
    }
}