<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaTipoExperiencia extends Model
{
    protected $table = 'pregunta_tipo_experiencia';

    protected $fillable = [
        'pregunta_id',
        'tipo_experiencia_id',
        'texto',
    ];

    public function pregunta()
    {
        return $this->belongsTo(
            Pregunta::class,
            'pregunta_id'
        );
    }

    public function tipoExperiencia()
    {
        return $this->belongsTo(
            TipoExperiencia::class,
            'tipo_experiencia_id'
        );
    }
}