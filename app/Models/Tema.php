<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;

class Tema extends Model
{
    use Searchable;
    protected $table = 'temas';

    protected $fillable = [
        'factor_id',
        'nombre',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function factor()
    {
        return $this->belongsTo(Factor::class, 'factor_id');
    }

}