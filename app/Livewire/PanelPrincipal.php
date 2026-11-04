<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Plantilla;
use App\Models\Pregunta;
use App\Models\User;

class PanelPrincipal extends Component
{
    public function render()
    {
        return view('livewire.panel-principal', [
            'totalPlantillas' => Plantilla::count(),
            'totalUsuarios' => User::count(),
            'preguntasActivas' => Pregunta::where('activo', true)->count(),
            'preguntasInactivas' => Pregunta::where('activo', false)->count(),
        ]);
    }
}
