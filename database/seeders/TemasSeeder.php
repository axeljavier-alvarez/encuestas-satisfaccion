<?php

namespace Database\Seeders;

use App\Models\Factor;
use App\Models\Tema;
use Illuminate\Database\Seeder;
use RuntimeException;

class TemasSeeder extends Seeder
{
    public function run(): void
    {
        $temasPorFactor = [
            'Recomendación' => [
                'Probabilidad de recomendar',
            ],

            'Atribución institucional' => [
                'Reconocimiento de responsables',
            ],

            'Difusión y acceso' => [
                'Primer canal de conocimiento',
                'Conjunto de canales de conocimiento',
                'Facilidad de acceso',
            ],

            'Vinculación municipal' => [
                'Contacto con canales municipales',
                'Experiencia del contacto municipal',
            ],

            'Atención y acompañamiento' => [
                'Trato amable y respetuoso',
                'Comunicación y seguimiento',
                'Resolución de dudas',
                'Apoyo en la participación',
                'Puntualidad del personal',
                'Presentación del personal',
                'Servicios municipales de apoyo',
                'Disponibilidad de acompañamiento',
            ],

            'Calidad del servicio o contenido' => [
                'Satisfacción con la experiencia',
                'Descripción de la experiencia',
                'Capacidad técnica del personal',
                'Claridad de enseñanza o explicación',
                'Calidad del contenido',
                'Desarrollo de las actividades',
                'Calidad de la atención especializada',
                'Calidad de la función cultural',
                'Establecimientos visitados',
                'Repertorio o programación artística',
            ],

            'Condiciones de prestación' => [
                'Duración',
                'Horario',
                'Ubicación',
                'Instalaciones',
                'Limpieza e higiene',
                'Mobiliario',
                'Disponibilidad de materiales',
                'Adecuación de materiales a la edad',
                'Utilidad de materiales de apoyo',
                'Equipo utilizado',
                'Sonido del evento',
                'Escenario y montaje',
                'Iluminación',
                'Cantidad de asientos',
                'Conexión virtual',
                'Audio virtual',
                'Imagen virtual',
                'Entorno visual virtual',
                'Seguridad percibida',
                'Espacio asignado',
                'Distribución y orden',
                'Movilidad y circulación',
                'Parqueo',
                'Precios de comerciantes',
                'Variedad de oferta comercial',
                'Elaboración de materiales en casa',
                'Medios de información',
                'Acceso a materiales para elaborar',
                'Espacios verdes',
                'Monumentos y atractivos',
                'Día de realización',
                'Música de acompañamiento',
            ],

            'Utilidad y resultados' => [
                'Utilidad del aprendizaje o servicio',
                'Desarrollo de habilidades',
                'Bienestar de la niñez',
                'Resultados comerciales',
                'Beneficio percibido en sus propias palabras',
                'Valoración del apoyo municipal',
                'Desarrollo de la niñez',
                'Acuerdo con la oferta municipal',
            ],

            'Mejoras y necesidades futuras' => [
                'Aspectos por mejorar',
                'Sugerencias abiertas',
                'Demanda de nuevas actividades',
                'Destinos y recorridos de interés',
                'Motivación de participación',
                'Aspectos más valorados',
                'Mejoras de comerciantes',
            ],

            'Incidencias e integridad' => [
                'Solicitud de pagos o donaciones',
                'Detalle de pago o donación',
                'Problemas o inconvenientes',
                'Descripción de la incidencia',
            ],
        ];

        foreach ($temasPorFactor as $nombreFactor => $temas) {

            $factor = Factor::where('nombre', $nombreFactor)
                ->first();

            if (!$factor) {
                throw new RuntimeException(
                    "No existe el factor: {$nombreFactor}"
                );
            }

            foreach ($temas as $nombreTema) {
                Tema::updateOrCreate(
                    ['nombre' => $nombreTema],
                    [
                        'factor_id' => $factor->id,
                        'activo' => true,
                    ]
                );
            }
        }
    }
}
