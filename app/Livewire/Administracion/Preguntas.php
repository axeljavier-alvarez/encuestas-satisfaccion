<?php

namespace App\Livewire\Administracion;

use App\Models\{Factor, Pregunta};
use App\Traits\{DataTable, Interact};
use Livewire\Component;
use Livewire\Attributes\Computed;

class Preguntas extends Component
{
    use DataTable, Interact;
    public ?int $factorSeleccionado = null;
    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'texto', 'label' => 'Pregunta'],
        ['index' => 'obligatoria', 'label' => 'Obligatoria'],
        ['index' => 'activo', 'label' => 'Estado'],
    ];

    // Columnas permitidas para ordenar
    protected function tableSortableColumns(): array
    {
        return [
            'id',
            'codigo',
            'texto',
            'obligatoria',
            'activo',
        ];
    }

     // Columnas permitidas para filtrar
    protected function tableFilterableColumns(): array
    {
        return [
            'id',
            'codigo',
            'texto',
            'obligatoria',
            'activo',
        ];
    }

    public function seleccionarFactor(int $factorId): void
    {
        Factor::findOrFail($factorId);
        $this->factorSeleccionado = $factorId;
        $this->search = '';
        $this->clearFilters();
        $this->resetPage();
    }

    public function regresarFactores(): void
    {
        $this->factorSeleccionado = null;
        $this->search  = '';
        $this->clearFilters();
        $this->resetPage();
    }

    
    #[Computed]
    public function rows()
    {
        $query = Pregunta::query();

        // Filtrar únicamente las preguntas del factor seleccionado
        if ($this->factorSeleccionado === null) {
            $query->whereRaw('1 = 0');
        } else {
            $query->where('factor_id', $this->factorSeleccionado);
        }

        // Preparar filtros con la configuración actual de DataTable
        $filters = $this->processFilters();

        // Aplicar búsqueda, filtros y ordenamiento con Searchable
        $query->filterAdvance($this->headers, [
            'search' => $this->search,
            'filters' => $filters,
            'sort' => [
                'field' => $this->sortBy,
                'direction' => $this->sortDirection,
            ],
        ]);

        return $query->paginate($this->getPerPage());
    }


    public function render()
    {
        $factores = Factor::query()
        ->withCount(['temas', 'preguntas'])
        ->orderBy('id')
        ->get();

        $factorActual = $this->factorSeleccionado
        ? $factores->firstWhere('id', $this->factorSeleccionado)
        : null;

        
        return view('livewire.administracion.preguntas', [
            'factores' => $factores,
            'factorActual' => $factorActual,
            'totalPreguntas' => $factores->sum('preguntas_count')
        ]);
    }
}
