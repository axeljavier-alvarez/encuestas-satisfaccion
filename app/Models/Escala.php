<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    protected $table = 'escalas';

    protected $fillable = [
        'nombre',
        'minimo',
        'maximo',
        'permite_no_sabe',
        'permite_no_aplica',
    ];

    protected $casts = [
        'minimo' => 'integer',
        'maximo' => 'integer',
        'permite_no_sabe' => 'boolean',
        'permite_no_aplica' => 'boolean',
    ];

    public function configuracionesRespuesta()
    {
        return $this->hasMany(
            PreguntaTipoRespuesta::class,
            'escala_id'
        );
    }

    public function preguntas()
    {
        return $this->belongsToMany(
            Pregunta::class,
            'pregunta_tipo_respuesta',
            'escala_id',
            'pregunta_id'
        )
        ->withPivot('id', 'tipo_respuesta_id')
        ->withTimestamps();
    }
}
