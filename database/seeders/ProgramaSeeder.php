<?php

namespace Database\Seeders;

use App\Models\Programa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramaSeeder extends Seeder
{
    public function run(): void
    {
        $programas = [
            [1, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [21, 4, 'EDAD DE ORO', 'A'],
            [41, 5, 'PRINCIPIANTE', 'A'],
            [42, 5, 'ESCUELA MUNICIPAL DE MUSICA', 'I'],
            [61, 4, 'BIBLIOTECAS PÚBLICAS MUNICIPALES', 'A'],
            [62, 4, 'CAPACITACIONES TÉCNICO PRODUCTIVAS', 'A'],
            [63, 4, 'ESCUELA MUNICIPAL DE FÚTBOL', 'A'],
            [64, 4, 'MUNIEDUCA MÓVIL', 'A'],
            [65, 4, 'CAPACITACIÓN PARA LA PREVENCIÓN DE RIESGO', 'A'],
            [66, 4, 'COMUNIDAD JUVENIL', 'A'],
            [67, 4, 'COMITÉ DE INNOVACIÓN SOCIAL', 'A'],
            [68, 4, 'CENTRO DE DÍA DEL ADULTO MAYOR', 'A'],
            [69, 4, 'ATENCIÓN INTEGRAL A PERSONAS CON DISCAPACIDAD', 'A'],
            [70, 4, 'FORTALECIMIENTO PARA LOS PROGRAMAS', 'A'],
            [81, 6, 'SENSIBILIZACIÓN EN GÉNERO', 'A'],
            [82, 6, 'DESARROLLO ECONÓMICO DE LAS MUJERES', 'A'],
            [83, 6, 'CASAS MUNICIPALES DE LA MUJER', 'A'],
            [84, 6, 'COMISIONES COMUNITARIAS DE LAS MUJERES', 'A'],
            [101, 5, 'MINI-CHESS', 'A'],
            [102, 5, 'CENTROS MUNICIPALES', 'A'],
            [103, 5, 'ESCUELA TALLER', 'A'],
            [104, 5, 'INSTITUTOS Y ESCUELAS PÚBLICAS', 'A'],
            [105, 5, 'AJEDREZ PADRES DE FAMILIA', 'A'],
            [121, 5, 'MUNITEC', 'A'],
            [141, 5, 'BACHILLERATO MCD', 'A'],
            [142, 5, 'DIPLOMADO DISTRITAL', 'A'],
            [143, 5, 'DIPLOMADO ESPECIAL', 'A'],
            [144, 5, 'DIPLOMADO REGULAR', 'A'],
            [145, 5, 'DIPLOMADO REGULAR FD', 'A'],
            [146, 5, 'PROGRAMA ELEMENTAL', 'A'],
            [147, 5, 'PROGRAMA ELEMENTAL FD', 'A'],
            [148, 5, 'ESTIMULACIÓN MUSICAL TEMPRANA', 'A'],
            [149, 5, 'PROGRAMA PREPARATORIO', 'A'],
            [161, 5, 'ESTIMULACIÓN TEMPRANA A TRAVÉS DEL MOVIMIENTO', 'A'],
            [162, 5, 'DANZA CREATIVA', 'A'],
            [163, 5, 'PREPARATORIO', 'I'],
            [164, 5, 'BALLET CREATIVO', 'A'],
            [165, 5, 'BALLET INICIAL', 'A'],
            [181, 5, 'DANZA CONTEMPORÁNEA Y JAZZ LÍRICO', 'A'],
            [182, 5, 'TÉCNICAS ESPECÍFICAS', 'I'],
            [183, 5, 'CURSOS LIBRES ADULTOS', 'I'],
            [184, 5, 'CURSO LIBRE DE NIÑOS Y ADOLESCENTES', 'I'],
            [185, 5, 'CURSO EXTRA 1 ESCULTURA', 'I'],
            [186, 5, 'CURSO EXTRA 2 ESCULTURA', 'I'],
            [187, 5, 'ESCUELAS PÚBLICAS', 'I'],
            [188, 5, 'DIPLOMADO EN ESCULTURA', 'A'],
            [189, 5, 'CURSO LIBRE DE ESCULTURA', 'A'],
            [201, 5, 'INTERMEDIO', 'A'],
            [202, 5, 'AVANZADO', 'A'],
            [221, 5, 'BACHILLERATO EN ARTES CON ESPECIALIZACIÓN EN DANZA CLÁSICA', 'A'],
            [241, 5, 'BACHILLERATO EN EDUCACIÓN MUSICAL', 'A'],
            [261, 5, 'NIÑOS Y ADOLESCENTES', 'A'],
            [262, 5, 'ADULTOS SEDE DISTRITAL', 'A'],
            [263, 5, 'NIÑOS Y ADOLESCENTES SEDE DISTRITAL', 'A'],
            [281, 5, 'TALLERES LIBRES', 'A'],
            [301, 5, 'DIPLOMADO EN ARTES VISUALES', 'A'],
            [321, 5, 'ESCUELAS PÚBLICAS', 'A'],
            [341, 5, 'ESCUELAS PÚBLICAS', 'A'],
            [342, 5, 'CENTROS MUNICIPALES', 'A'],
            [343, 5, 'ESCUELAS PÚBLICAS', 'A'],
            [361, 5, 'DIPLOMADO EN ARTE CONTEMPORÁNEO', 'A'],
            [381, 5, 'NIÑOS Y ADOLESCENTES', 'A'],
            [401, 5, 'INFANTIL', 'A'],
            [421, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [441, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [461, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [462, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [463, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [464, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [481, 5, 'CURSOS LIBRES', 'A'],
            [501, 8, 'MÁS VIDA', 'A'],
            [502, 8, 'BIENESTAR ANIMAL', 'A'],
            [503, 5, 'DIPLOMADO TECNOLÓGICO', 'A'],
            [504, 5, 'DIPLOMADO EN PRODUCCIÓN MUSICAL', 'I'],
            [521, 6, 'ESTILOS DE VIDA SALUDABLE', 'A'],
            [541, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [561, 8, 'NIÑEZ Y ADOLESCENCIA CON PROPÓSITO', 'A'],
            [581, 8, 'NIÑEZ Y ADOLESCENCIA CON PROPÓSITO', 'A'],
            [582, 8, 'NIÑEZ Y ADOLESCENCIA CON PROPÓSITO', 'A'],
            [583, 8, 'NIÑEZ Y ADOLESCENCIA CON PROPÓSITO', 'A'],
            [584, 8, 'NIÑEZ Y ADOLESCENCIA CON PROPÓSITO', 'A'],
            [585, 8, 'CON TUS HIJOS CUMPLE', 'A'],
            [601, 8, 'JARDINES INFANTILES MUNICIPALES', 'A'],
            [621, 21, 'INCUBADORA DE NEGOCIOS', 'A'],
            [641, 5, 'CEEX', 'A'],
            [661, 5, 'CEMUCAF', 'A'],
            [681, 21, 'CENTRO DE EMPRENDIMIENTO', 'A'],
            [701, 5, 'EVENTOS Y ACTIVIDADES', 'A'],
            [702, 5, 'COORDINACIÓN DE EDUCACIÓN ARTÍSTICA', 'A'],
            [721, 5, 'IMPULSATEC', 'A'],
            [741, 21, 'SENSIBILIZACIÓN', 'A'],
            [761, 5, 'CENTROS MUNICIPALES', 'A'],
            [781, 5, 'TALLERES LIBRES', 'A'],
            [782, 5, 'TALLERES LIBRES', 'A'],
            [801, 8, 'IMPULSATEC SAS', 'A'],
            [821, 8, 'NUTRIHUERTOS', 'A'],
            [841, 5, 'INSTITUTOS PUBLICOS', 'A'],
            [861, 6, 'MUJER EMPRENDE', 'A'],
            [881, 5, 'ESCUELA TALLER', 'A'],
            [901, 2, 'ATENCION CLINICA MUNICIPAL', 'A'],
        ];

        DB::transaction(function () use ($programas) {
            foreach ($programas as [
                $id,
                $dependenciaId,
                $nombre,
                $estado
            ]) {
                Programa::updateOrCreate(
                    ['id' => $id],
                    [
                        'dependencia_id' => $dependenciaId,
                        'nombre' => $nombre,
                        'estado' => $estado,
                    ]
                );
            }
        });
    }
}