<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoRespuesta extends Model
{
    protected $table = 'tipos_respuesta';

    protected $fillable = [
        'nombre',
    ];

    public function preguntas()
    {
        return $this->belongsToMany(
            Pregunta::class,
            'pregunta_tipo_respuesta',
            'tipo_respuesta_id',
            'pregunta_id'
        )
        ->withPivot('id', 'escala_id')
        ->withTimestamps();
    }

    public function configuracionesRespuesta()
    {
        return $this->hasMany(
            PreguntaTipoRespuesta::class,
            'tipo_respuesta_id'
        );
    }
}
