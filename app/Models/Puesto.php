<?php

namespace App\Models;

use App\Models\Empleado;
use App\Models\Plantilla;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';

    protected $fillable = [
        'plantilla_id',
        'nombre',
        'codigo',
        'activo',
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    
}
