<?php

namespace App\Models;

use App\Models\Empleado;
use App\Models\Plantilla;
use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';

    protected $fillable = [
        'empleado_evaluador_id',
        'empleado_evaluado_id',
        'plantilla_id',
        'estado',
        'fecha_finalizacion',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_finalizacion' => 'datetime',
        ];
    }

    public function evaluador()
    {
        return $this->belongsTo(Empleado::class, 'empleado_evaluador_id');
    }

    public function evaluado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_evaluado_id');
    }

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    public function respuestas()
    {
        return $this->hasMany(Respuesta::class);
    }

}
