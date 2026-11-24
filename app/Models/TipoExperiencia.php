<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Searchable;

class TipoExperiencia extends Model
{
    use Searchable;
    protected $table = 'tipos_experiencia';
    protected $fillable = [
        'nombre',
        'activo'
    ];
    protected function casts(): array
    {
        return [
            'activo' => 'boolean'
        ];
    }
    public function plantillas()
    {
        return $this->hasMany(
            Plantilla::class,
            'tipo_experiencia_id'
        );
    }
}
