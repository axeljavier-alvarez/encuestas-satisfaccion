<?php

namespace App\Livewire\Evaluaciones;

use App\Models\Evaluacion;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MisEvaluaciones extends Component
{
    /**
     * Muestra las evaluaciones asignadas al usuario autenticado.
     */
    public function render(): View
    {
        $usuario = Auth::user();
        $empleado = $usuario->empleado;

        /*
         * Esta validación evita errores si un usuario existe,
         * pero todavía no tiene un empleado asociado.
         */
        if (! $empleado) {
            return view('livewire.evaluaciones.mis-evaluaciones', [
                'usuario' => $usuario,
                'empleado' => null,
                'evaluacionesPendientes' => collect(),
                'evaluacionesFinalizadas' => collect(),
            ]);
        }

        /*
         * Evaluaciones que todavía debe responder el usuario.
         */
        $evaluacionesPendientes = Evaluacion::query()
            ->with([
                'evaluado.usuario',
                'evaluado.puesto',
                'plantilla',
            ])
            ->where('empleado_evaluador_id', $empleado->id)
            ->where('estado', 'pendiente')
            ->orderBy('id')
            ->get();

        /*
         * Evaluaciones que el usuario ya respondió.
         */
        $evaluacionesFinalizadas = Evaluacion::query()
            ->with([
                'evaluado.usuario',
                'evaluado.puesto',
                'plantilla',
            ])
            ->where('empleado_evaluador_id', $empleado->id)
            ->where('estado', 'finalizada')
            ->latest('fecha_finalizacion')
            ->get();

            return view('livewire.evaluaciones.mis-evaluaciones', [
                'usuario' => $usuario,
                'empleado' => $empleado,
                'evaluacionesPendientes' => $evaluacionesPendientes,
                'evaluacionesFinalizadas' => $evaluacionesFinalizadas,
            ]);
    }
}