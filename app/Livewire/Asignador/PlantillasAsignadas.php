<?php

namespace App\Livewire\Asignador;

use App\Models\Plantilla;
use App\Traits\{DataTable, Interact};
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Override;

class PlantillasAsignadas extends Component
{
    use DataTable, Interact;
    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'nombre', 'label' => 'Nombre'],
        ['index' => 'descripcion', 'label' => 'Descripción'],
        ['index' => 'preguntas_count', 'label' => 'Preguntas'],
        ['index' => 'estado', 'label' => 'Estado'],
        [
            'index' => 'created_at',
            'label' => 'Fecha de creación',
            'format' => 'date',
        ],
        ['index' => 'actions', 'label' => 'Acciones'],
    ];

    protected function tableSortableColumns(): array
    {
        return [
            'id',
            'codigo',
            'nombre',
            'preguntas_count',
            'estado',
            'created_at',
        ];
    }

    protected function tableFilterableColumns(): array
    {
        return [
            'id',
            'codigo',
            'nombre',
            'descripcion',
            'estado',
        ];
    }

    private function consultaPlantillas(): Builder
    {
        return Plantilla::query()
            ->whereHas('usuarios', function ($query) {
                $query->where('users.id', auth()->id());
            });
    }
    #[Computed]
    public function rows()
    {
        $query = $this->consultaPlantillas()
            ->withCount('preguntas');

        $query->filterAdvance($this->headers, [
            'search' => $this->search,
            'filters' => $this->processFilters(),
            'sort' => [
                'field' => $this->sortBy,
                'direction' => $this->sortDirection,
            ],
        ]);

        if ($this->sortBy === 'id') {
            $query->reorder()
                ->orderByRaw("
                    CASE
                        WHEN estado = 'publicada' THEN 1
                        WHEN estado = 'borrador' THEN 2
                        WHEN estado = 'inactiva' THEN 3
                        ELSE 4
                    END
                ")
                ->orderBy('id', $this->sortDirection);
        }
        return $query->paginate($this->getPerPage());
    }



    public function render()
    {
        $estadisticas = $this->consultaPlantillas()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("
                SUM(
                    CASE WHEN estado = 'borrador'
                    THEN 1 ELSE 0 END
                ) as borradores
            ")
            ->selectRaw("
                SUM(
                    CASE WHEN estado = 'publicada'
                    THEN 1 ELSE 0 END
                ) as publicadas
            ")
            ->selectRaw("
                SUM(
                    CASE WHEN estado = 'inactiva'
                    THEN 1 ELSE 0 END
                ) as inactivas
            ")
            ->first();

        return view('livewire.asignador.plantillas-asignadas', [
            'estadisticas' => $estadisticas,
        ]);
    }
}
