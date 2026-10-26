<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $fillable = [
        'pregunta_id',
        'opcion_respuesta_id',
        'respuesta_texto',
        'puntaje_nps',
    ];

    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function opcion()
    {
        return $this->belongsTo(OpcionRespuesta::class, 'opcion_respuesta_id');
    }
}
