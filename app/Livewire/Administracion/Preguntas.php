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

    public function mount(?string $slug= null):void
    {
        if ($slug !== null){
            $factor = Factor::where('slug', $slug)->firstOrFail();
            $this->factorSeleccionado = $factor->id;
        }
    }

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
        $factor = Factor::findOrFail($factorId);

        $this->redirectRoute(
            'administracion.preguntas.factor',
            ['slug' => $factor->slug],
            navigate: true
        );
    }

    public function regresarFactores(): void
    {
        $this->redirectRoute(
            'administracion.preguntas',
            navigate: true
        );
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

        $temas = $factorActual
        ? $factorActual->temas()->orderBy('id')->get()
        : collect();

        $estadisticas = Pregunta::query()
        ->selectRaw('COUNT(*) as total')
        ->selectRaw('SUM(CASE WHEN activo = 1 THEN 1 ELSE 0 END) as activas')
        ->selectRaw('SUM(CASE WHEN activo = 0 THEN 1 ELSE 0 END) as inactivas')
        ->first();

        return view('livewire.administracion.preguntas', [
            'factores' => $factores,
            'factorActual' => $factorActual,
            'temas' => $temas,
            'totalPreguntas' => $factores->sum('preguntas_count')
        ]);
    }
}
