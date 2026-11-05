<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    protected $table = 'plantillas';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }


    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'plantilla_usuario',
            'plantilla_id',
            'user_id'
        )->withTimestamps();
    }


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
