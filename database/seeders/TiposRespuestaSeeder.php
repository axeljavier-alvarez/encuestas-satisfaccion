<?php

namespace Database\Seeders;

use App\Models\TipoRespuesta;
use Illuminate\Database\Seeder;

class TiposRespuestaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            'Escala de 0 a 10',
            'Selección única',
            'Selección múltiple',
            'Texto abierto',
        ];

        foreach ($tipos as $nombre) {
            TipoRespuesta::firstOrCreate([
                'nombre' => $nombre,
            ]);
        }
    }
}