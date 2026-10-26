<?php

namespace App\Livewire\Administracion;

use App\Models\Evaluacion;
use App\Models\Plantilla;
use Livewire\Component;
use Livewire\WithPagination;

class SeguimientoEvaluaciones extends Component
{
    use WithPagination;

    public string $buscar = '';

    public string $estado = '';

    public ?int $plantillaId = null;

    /**
     * Regresa a la primera página cuando cambia la búsqueda.
     */
    public function updatedBuscar(): void
    {
        $this->resetPage();
    }

    /**
     * Regresa a la primera página cuando cambia el estado.
     */
    public function updatedEstado(): void
    {
        $this->resetPage();
    }

    /**
     * Regresa a la primera página cuando cambia la plantilla.
     */
    public function updatedPlantillaId(): void
    {
        $this->resetPage();
    }

    /**
     * Limpia todos los filtros.
     */
    public function limpiarFiltros(): void
    {
        $this->reset(
            'buscar',
            'estado',
            'plantillaId'
        );

        $this->resetPage();
    }

    /**
     * Carga los indicadores, filtros y evaluaciones.
     */
    public function render()
    {
        /*
         * Indicadores generales.
         * Estos valores no cambian aunque se utilicen filtros.
         */
        $totalEvaluaciones = Evaluacion::count();

        $totalPendientes = Evaluacion::query()
            ->where('estado', 'pendiente')
            ->count();

        $totalFinalizadas = Evaluacion::query()
            ->where('estado', 'finalizada')
            ->count();

        $porcentajeAvance = $totalEvaluaciones > 0
            ? round(($totalFinalizadas / $totalEvaluaciones) * 100, 1)
            : 0;

        /*
         * Consulta principal de la tabla.
         */
        $evaluaciones = Evaluacion::query()
            ->with([
                'evaluador.usuario',
                'evaluador.puesto',
                'evaluado.usuario',
                'evaluado.puesto',
                'plantilla',
            ])
            ->when(
                $this->buscar,
                function ($consulta) {
                    $consulta->where(function ($subconsulta) {
                        /*
                         * Busca por nombre o puesto del evaluador.
                         */
                        $subconsulta
                            ->whereHas(
                                'evaluador.usuario',
                                function ($usuarios) {
                                    $usuarios->where(
                                        'name',
                                        'like',
                                        '%' . $this->buscar . '%'
                                    );
                                }
                            )
                            ->orWhereHas(
                                'evaluador.puesto',
                                function ($puestos) {
                                    $puestos
                                        ->where(
                                            'nombre',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        )
                                        ->orWhere(
                                            'codigo',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        );
                                }
                            )
                            /*
                             * Busca por nombre o puesto del evaluado.
                             */
                            ->orWhereHas(
                                'evaluado.usuario',
                                function ($usuarios) {
                                    $usuarios->where(
                                        'name',
                                        'like',
                                        '%' . $this->buscar . '%'
                                    );
                                }
                            )
                            ->orWhereHas(
                                'evaluado.puesto',
                                function ($puestos) {
                                    $puestos
                                        ->where(
                                            'nombre',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        )
                                        ->orWhere(
                                            'codigo',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        );
                                }
                            );
                    });
                }
            )
            ->when(
                $this->estado,
                fn ($consulta) => $consulta->where(
                    'estado',
                    $this->estado
                )
            )
            ->when(
                $this->plantillaId,
                fn ($consulta) => $consulta->where(
                    'plantilla_id',
                    $this->plantillaId
                )
            )
            ->orderByRaw("
                CASE
                    WHEN estado = 'pendiente' THEN 1
                    ELSE 2
                END
            ")
            ->orderBy('id')
            ->paginate(12);

        /*
         * Plantillas disponibles para el filtro.
         */
        $plantillas = Plantilla::query()
            ->orderBy('codigo')
            ->get();

        return view(
            'livewire.administracion.seguimiento-evaluaciones',
            [
                'evaluaciones' => $evaluaciones,
                'plantillas' => $plantillas,
                'totalEvaluaciones' => $totalEvaluaciones,
                'totalPendientes' => $totalPendientes,
                'totalFinalizadas' => $totalFinalizadas,
                'porcentajeAvance' => $porcentajeAvance,
            ]
        );
    }
}