<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;

class Factor extends Model
{
    use Searchable;
    protected $table = 'factores';
    protected $fillable = [
        'nombre',
        'slug',
        'activo',
    ];
    protected $casts = [
        'activo' => 'boolean',
    ];
    public function temas()
    {
        return $this->hasMany(Tema::class, 'factor_id');
    }

    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'factor_id');
    }


}
