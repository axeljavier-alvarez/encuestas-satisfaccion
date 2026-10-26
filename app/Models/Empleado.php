<?php

namespace App\Models;

use App\Models\Evaluacion;
use App\Models\Puesto;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'user_id',
        'puesto_id',
        'jefe_id',
        'activo',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function jefe()
    {
        return $this->belongsTo(Empleado::class, 'jefe_id');
    }

    public function subalternos()
    {
        return $this->hasMany(Empleado::class, 'jefe_id');
    }

    public function evaluacionesPorResponder()
    {
        return $this->hasMany(Evaluacion::class, 'empleado_evaluador_id');
    }

    public function evaluacionesRecibidas()
    {
        return $this->hasMany(Evaluacion::class, 'empleado_evaluado_id');
    }

}
