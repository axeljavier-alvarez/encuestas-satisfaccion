<?php

namespace Database\Seeders;

use App\Models\Tema;
use Illuminate\Database\Seeder;

class TemasSeeder extends Seeder
{
    public function run(): void
    {
        $temas = [
            'Probabilidad de recomendar',
            'Reconocimiento de responsables',
            'Primer canal de conocimiento',
            'Conjunto de canales de conocimiento',
            'Facilidad de acceso',
            'Contacto con canales municipales',
            'Experiencia del contacto municipal',
            'Trato amable y respetuoso',
            'Comunicación y seguimiento',
            'Resolución de dudas',
            'Apoyo en la participación',
            'Puntualidad del personal',
            'Presentación del personal',
            'Servicios municipales de apoyo',
            'Disponibilidad de acompañamiento',
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
            'Utilidad del aprendizaje o servicio',
            'Desarrollo de habilidades',
            'Bienestar de la niñez',
            'Resultados comerciales',
            'Beneficio percibido en sus propias palabras',
            'Valoración del apoyo municipal',
            'Desarrollo de la niñez',
            'Acuerdo con la oferta municipal',
            'Aspectos por mejorar',
            'Sugerencias abiertas',
            'Demanda de nuevas actividades',
            'Destinos y recorridos de interés',
            'Motivación de participación',
            'Aspectos más valorados',
            'Mejoras de comerciantes',
            'Solicitud de pagos o donaciones',
            'Detalle de pago o donación',
            'Problemas o inconvenientes',
            'Descripción de la incidencia',
        ];

        foreach ($temas as $nombre) {
            Tema::updateOrCreate(
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