<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionRespuesta extends Model
{
    protected $table = 'opciones_respuesta';

    protected $fillable = [
        'pregunta_tipo_respuesta_id',
        'valor',
        'etiqueta',
        'es_excluyente',
        'habilita_texto',
        'etiqueta_texto_adicional',
    ];

    protected function casts(): array
    {
        return [
            'es_excluyente' => 'boolean',
            'habilita_texto' => 'boolean',
        ];
    }

    // Cada opción pertenece a una configuración
    public function configuracionRespuesta()
    {
        return $this->belongsTo(
            PreguntaTipoRespuesta::class,
            'pregunta_tipo_respuesta_id'
        );
    }

    public function respuestas()
    {
        return $this->hasMany(
            Respuesta::class,
            'opcion_respuesta_id'
        );
    }
}
