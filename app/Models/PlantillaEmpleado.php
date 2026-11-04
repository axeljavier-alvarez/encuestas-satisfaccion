<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaEmpleado extends Model
{
    protected $table = 'plantilla_empleado';

    protected $fillable = [
        'plantilla_id',
        'empleado_id'
    ];

    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
