<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Plantilla;
use App\Models\TipoExperiencia;

class PlantillaSeeder extends Seeder
{
    public function run(): void
    {
        $plantillas = [
            [
                'codigo' => 'SB-100',
                'nombre' => 'SB-100-DDS-ATENCIÓN INTEGRAL A PERSONAS CON DISCAPACIDAD',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-101',
                'nombre' => 'SB-101-DDS-BIBLIOTECAS PÚBLICAS MUNICIPALES',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-102',
                'nombre' => 'SB-102-DDS-CAPACITACIONES PARA LA PREVENCIÓN DE RIESGOS',
                'tipo_experiencia' => 'Taller',
            ],
            [
                'codigo' => 'SB-103',
                'nombre' => 'SB-103-DDS-CAPACITACIONES TÉCNICO PRODUCTIVAS',
                'tipo_experiencia' => 'Curso',
            ],
            [
                'codigo' => 'SB-104',
                'nombre' => 'SB-104-DDS-CENTRO DE DÍA DEL ADULTO MAYOR',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-105',
                'nombre' => 'SB-105-DDS-COMUNIDAD JUVENIL',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-106',
                'nombre' => 'SB-106-DDS-EDAD DE ORO',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-107',
                'nombre' => 'SB-107-DDS-EMEFUT',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-108',
                'nombre' => 'SB-108-DDS-MUNIEDUCA MÓVIL',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-109',
                'nombre' => 'SB-109-DDS-COMITÉ DE INNOVACIÓN SOCIAL',
                'tipo_experiencia' => 'Iniciativa',
            ],
            [
                'codigo' => 'SB-110',
                'nombre' => 'SB-110-DDS-FORTALECIMIENTO A LOS PROGRAMAS',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-111',
                'nombre' => 'SB-111-DDS-PROGRAMAS CULTURALES',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-201',
                'nombre' => 'SB-201-Mapa en Relieve',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-203',
                'nombre' => 'SB-203-Escuela Taller',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-204',
                'nombre' => 'SB-204-Galerías de Arte',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-205',
                'nombre' => 'SB-205-Educación y Cultura-Encuesta para Adultos',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-206',
                'nombre' => 'SB-206-Munitec',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-207',
                'nombre' => 'SB-207-Educación y Cultura Padres de familia',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-413',
                'nombre' => 'SB-413-Secretaría de Asuntos Sociales- Programa Más Vida Club Más Vida y Curso Cocina con Más Vida 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-414',
                'nombre' => 'SB-414-Secretaría de Asuntos Sociales -Programa Nutrihuerto 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-415',
                'nombre' => 'SB-415-Secretaría de Asuntos Sociales -Programa Jardines Infantiles Municipales 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-416',
                'nombre' => 'SB-416-Secretaría de Asuntos Sociales-Programa Con tus Hijos Cumple 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-417',
                'nombre' => 'SB-417-Secretaría de Asuntos Sociales -Programa Más Familia 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-418',
                'nombre' => 'SB-418-Secretaría de Asuntos Sociales - Programa Niñez y Adolescencia con Propósito 2026',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-419',
                'nombre' => 'SB-419-Secretaría de Asuntos Sociales - Unidad Municipal de Bienestar Animal 2026',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-501',
                'nombre' => 'SB-501-Convivencia Social-Bicitour',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-502',
                'nombre' => 'SB-502-Convivencia Social-Club Run',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-503',
                'nombre' => 'SB-503-Convivencia Social-Pedaleando- Ando-',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-504',
                'nombre' => 'SB-504-Convivencia Social-Turibus',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-507',
                'nombre' => 'SB-507-Convivencia Social-Festival de Verano 2026',
                'tipo_experiencia' => 'Evento',
            ],
            [
                'codigo' => 'SB-508',
                'nombre' => 'SB-508-Convivencia-PasosyPedales/visitantes',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-509',
                'nombre' => 'SB-509-Convivencia Social-Pasos y Pedales / emprendedores',
                'tipo_experiencia' => 'Actividad',
            ],
            [
                'codigo' => 'SB-602',
                'nombre' => 'SB-602-DMM-sensibilizacion',
                'tipo_experiencia' => 'Taller',
            ],
            [
                'codigo' => 'SB-603',
                'nombre' => 'SB-603-DMM-Casas-Mujer',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-604',
                'nombre' => 'SB-604-DMM-Servicios-comisiones',
                'tipo_experiencia' => 'Servicio',
            ],
            [
                'codigo' => 'SB-605',
                'nombre' => 'SB-605-DMM-Estilos-de-vida-saludable',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-606',
                'nombre' => 'SB-606-DMM-Desarrollo-economico',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-607',
                'nombre' => 'SB-607-DMM-Mujer-Emprende',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-608',
                'nombre' => 'SB-608-DMM-ImpulsaTec',
                'tipo_experiencia' => 'Programa',
            ],
            [
                'codigo' => 'SB-704',
                'nombre' => 'SB-704- SEMANA MAYOR',
                'tipo_experiencia' => 'Evento',
            ],
            [
                'codigo' => 'SB-707',
                'nombre' => 'SB-707-FERIA DE JOCOTENANGO',
                'tipo_experiencia' => 'Evento',
            ],
            [
                'codigo' => 'SB-803',
                'nombre' => 'SB-803-CME-Trimestre 1-2026',
                'tipo_experiencia' => 'Programa',
            ],
        ];

        DB::transaction(function () use ($plantillas) {

            $tiposExperiencia = TipoExperiencia::query()
                ->where('activo', true)
                ->pluck('id', 'nombre');

            foreach ($plantillas as $plantilla) {

                $tipoExperienciaId = $tiposExperiencia->get(
                    $plantilla['tipo_experiencia']
                );

                if (!$tipoExperienciaId) {
                    throw new \RuntimeException(
                        'Tipo de experiencia no disponible: '
                        . $plantilla['tipo_experiencia']
                    );
                }

                Plantilla::firstOrCreate(
                    [
                        'codigo' => $plantilla['codigo'],
                    ],
                    [
                        'nombre' => $plantilla['nombre'],
                        'descripcion' => null,
                        'tipo_experiencia_id' => $tipoExperienciaId,
                        'estado' => 'borrador',
                    ]
                );
            }
        });
    }
}