<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dependencia extends Model
{
    protected $table = 'dependencias';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'nombre',
    ];

    /**
     * Programas asociados a la dependencia.
     */
    public function programas(): HasMany
    {
        return $this->hasMany(
            Programa::class,
            'dependencia_id'
        );
    }
}