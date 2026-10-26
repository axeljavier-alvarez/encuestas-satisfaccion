<?php

namespace App\Models;

use App\Models\Dimension;
use App\Models\Evaluacion;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    protected $table = 'plantillas';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'activo',
    ];

    // public function dimensiones()
    // {
    //     return $this->hasMany(Dimension::class);
    // }

    public function puestos()
    {
        return $this->hasMany(Puesto::class);
    }

    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class);
    }

    // relacion de plantillas con preguntas
    public function preguntas()
    {
        return $this->belongsToMany(
            Pregunta::class,
            'plantilla_pregunta',
            'plantilla_id',
            'pregunta_id'
        )
            ->withPivot('orden', 'tipo_respuesta_id')
            ->withTimestamps()
            ->orderByPivot('orden');
    }
}
