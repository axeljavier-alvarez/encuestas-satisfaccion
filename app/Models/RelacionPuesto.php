<?php

namespace App\Models;

use App\Models\Puesto;
use Illuminate\Database\Eloquent\Model;

class RelacionPuesto extends Model
{
    protected $table = 'relaciones_puestos';

    protected $fillable = [
        'puesto_evaluador_id',
        'puesto_evaluado_id',
        'plantilla_id',
        'tipo_relacion',
        'activo',
    ];

    public function puestoEvaluador()
    {
        return $this->belongsTo(Puesto::class, 'puesto_evaluador_id');
    }

    public function puestoEvaluado()
    {
        return $this->belongsTo(Puesto::class, 'puesto_evaluado_id');
    }

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }
}

