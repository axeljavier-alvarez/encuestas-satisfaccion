<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaUsuario extends Model
{
    protected $table = 'plantilla_usuario';

    protected $fillable = [
        'plantilla_id',
        'user_id',
    ];

    /**
     * Relación con la plantilla.
     */
    public function plantilla()
    {
        return $this->belongsTo(Plantilla::class);
    }

    /**
     * Relación con el usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
