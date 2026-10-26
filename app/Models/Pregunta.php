<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = 'preguntas';

    protected $fillable = [
        'codigo',
        'factor_id',
        'tema_id',
        'texto',
        'es_nps',
        'activo',
        'obligatoria',
        'es_predeterminada',
    ];

    protected function casts(): array
    {
        return [
            'es_nps' => 'boolean',
            'activo' => 'boolean',
            'obligatoria' => 'boolean',
            'es_predeterminada' => 'boolean',
        ];
    }

    public function scopePredeterminadasActivas($query)
    {
        return $query->where('es_predeterminada', true)
            ->where('activo', true);
    }


    public function factor()
    {
        return $this->belongsTo(Factor::class);
    }

    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function plantillas()
    {
        return $this->belongsToMany(
            Plantilla::class,
            'plantilla_pregunta',
            'pregunta_id',
            'plantilla_id'
        )
            ->withPivot('orden')
            ->withTimestamps();
    }

    // Una pregunta admite uno o varios tipos de respuesta
    public function tiposRespuesta()
    {
        return $this->belongsToMany(
            TipoRespuesta::class,
            'pregunta_tipo_respuesta',
            'pregunta_id',
            'tipo_respuesta_id'
        )
            ->withPivot('id', 'escala_id')
            ->withTimestamps();
    }

    // Configuraciones concretas de la pregunta
    /*
    $pregunta = Pregunta::with([
    'tiposRespuesta',
    'configuracionesRespuesta.tipoRespuesta',
    'configuracionesRespuesta.escala',
    'configuracionesRespuesta.opcionesRespuesta',
   ])->findOrFail(1);

    */
    public function configuracionesRespuesta()
    {
        return $this->hasMany(
            PreguntaTipoRespuesta::class,
            'pregunta_id'
        );
    }

    // Acceso a todas las opciones de la pregunta
    public function opcionesRespuesta()
    {
        return $this->hasManyThrough(
            OpcionRespuesta::class,
            PreguntaTipoRespuesta::class,
            'pregunta_id',
            'pregunta_tipo_respuesta_id',
            'id',
            'id'
        );
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }
}
