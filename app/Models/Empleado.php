<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'user_id',
        'puesto_id',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function plantillas()
    {
        return $this->belongsToMany(
            Plantilla::class,
            'plantilla_empleado',
            'empleado_id',
            'plantilla_id'
        )->withTimestamps();
    }
}
