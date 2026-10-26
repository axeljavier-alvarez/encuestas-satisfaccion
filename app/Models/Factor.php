<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = 'factores';
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
