<?php

namespace App\Models;

use App\Models\Empleado;
use App\Models\Plantilla;
use App\Models\RelacionPuesto;
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

    public function relacionesComoEvaluador()
    {
        return $this->hasMany(RelacionPuesto::class, 'puesto_evaluador_id');
    }

    public function relacionesComoEvaluado()
    {
        return $this->hasMany(RelacionPuesto::class, 'puesto_evaluado_id');
    }
}
