<?php

namespace App\Models;

use App\Models\Pregunta;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $table = 'temas';

    protected $fillable = [
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class);
    }
}