<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Programa extends Model
{
    protected $table = 'programas';

    public $timestamps = false;

    public $incrementing = false;

    protected $fillable = [
        'id',
        'dependencia_id',
        'nombre',
        'estado',
    ];

    /**
     * Dependencia a la que pertenece el programa.
     */
    public function dependencia(): BelongsTo
    {
        return $this->belongsTo(
            Dependencia::class,
            'dependencia_id'
        );
    }
}