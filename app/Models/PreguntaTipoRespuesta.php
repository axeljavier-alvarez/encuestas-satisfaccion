<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaTipoRespuesta extends Model
{
    protected $table = 'pregunta_tipo_respuesta';

    protected $fillable = [
        'pregunta_id',
        'tipo_respuesta_id',
        'escala_id',
    ];

    public function pregunta()
    {
        return $this->belongsTo(
            Pregunta::class,
            'pregunta_id'
        );
    }

    public function tipoRespuesta()
    {
        return $this->belongsTo(
            TipoRespuesta::class,
            'tipo_respuesta_id'
        );
    }

    public function escala()
    {
        return $this->belongsTo(
            Escala::class,
            'escala_id'
        );
    }

    public function opcionesRespuesta()
    {
        return $this->hasMany(
            OpcionRespuesta::class,
            'pregunta_tipo_respuesta_id'
        );
    }
}