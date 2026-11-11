<?php

namespace App\Livewire\Administracion;

use App\Models\{Factor, Pregunta, Tema, TipoRespuesta};
use App\Traits\{DataTable, Interact};
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Flux\Flux;

class Preguntas extends Component
{
    use DataTable, Interact;
    public ?int $temaId = null;
    public ?int $factorSeleccionado = null;
    public array $tiposRespuestaSeleccionados = [];
    public string $obligatoria = '';
    public string $texto = '';
    // cambio de estado
    public ?int $preguntaEstadoId = null;
    public string $nombrePreguntaEstado = '';
    public bool $nuevoEstadoPregunta = false;

    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'texto', 'label' => 'Pregunta'],
        ['index' => 'tema.nombre', 'label' => 'Tema / Aspecto'],
        ['index' => 'tiposRespuesta.nombre', 'label' => 'Tipo de respuesta'],
        ['index' => 'obligatoria', 'label' => 'Obligatoria'],
        ['index' => 'activo', 'label' => 'Estado'],
        ['index' => 'actions', 'label' => 'Acciones']
    ];

    public function mount(?string $slug = null): void
    {
        if ($slug !== null) {
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
            'tema.nombre',
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
        $query = Pregunta::query()->with('tema', 'tiposRespuesta');

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

        // Priorizar preguntas activas cuando se ordena por ID
        if ($this->sortBy === 'id') {
            $query->reorder('activo', 'desc')
                ->orderBy('id', $this->sortDirection);
        }

        return $query->paginate($this->getPerPage());
    }

    // abrir modal de pregunta
    public function abrirNuevaPregunta(): void
    {
        if ($this->factorSeleccionado === null) {
            return;
        }

        $this->reset([
            'temaId',
            'texto',
            'obligatoria',
            'tiposRespuestaSeleccionados',
        ]);

        $this->resetValidation();

        Flux::modal('nueva-pregunta')->show();
    }

    public function cerrarNuevaPregunta(): void
    {
        $this->reset([
            'temaId',
            'texto',
            'obligatoria',
            'tiposRespuestaSeleccionados',
        ]);

        $this->resetValidation();

        Flux::modal('nueva-pregunta')->close();
    }

    // generar codigo
    private function generarCodigo(string $nombreFactor)
    {
        $prefijos = [
            'Recomendación' => 'REC',
            'Atribución institucional' => 'ATR',
            'Difusión y acceso' => 'DIF',
            'Vinculación municipal' => 'VIN',
            'Atención y acompañamiento' => 'ATN',
            'Calidad del servicio o contenido' => 'CAL',
            'Condiciones de prestación' => 'CON',
            'Utilidad y resultados' => 'UTL',
            'Mejoras y necesidades futuras' => 'MEJ',
            'Incidencias e integridad' => 'INC',
        ];

        $prefijo = $prefijos[$nombreFactor]
            ?? throw new \InvalidArgumentException(
                'El factor no tiene un prefijo configurado'
            );
        $codigos = Pregunta::query()
            ->where('codigo', 'like', $prefijo . '-%')
            ->pluck('codigo');

        $ultimoNumero = $codigos
            ->map(function ($codigo) use ($prefijo) {
                if (preg_match(
                    '/^' . preg_quote($prefijo, '/') . '-(\d+)$/',
                    $codigo,
                    $coincidencias
                )) {
                    return (int) $coincidencias[1];
                }

                return 0;
            })
            ->max() ?? 0;

        $siguiente = $ultimoNumero + 1;

        return $prefijo . '-' . str_pad(
            (string) $siguiente,
            2,
            '0',
            STR_PAD_LEFT
        );
    }

    public function guardar(): void
    {
        if ($this->factorSeleccionado === null) {
            return;
        }
        $this->validate([
            'temaId' => [
                'required',
                'integer',
                Rule::exists('temas', 'id')
                    ->where('factor_id', $this->factorSeleccionado),
            ],
            'texto' => [
                'required',
                'string',
                'max:1000',
            ],
            'obligatoria' => [
                'required',
                Rule::in(['0', '1']),
            ],
            'tiposRespuestaSeleccionados' => [
                'required',
                'array',
                'min:1',
            ],
            'tiposRespuestaSeleccionados.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('tipos_respuesta', 'id'),
            ],
        ]);
        
        DB::transaction(function() {
            $factor = Factor::findOrFail(
                $this->factorSeleccionado
            );
            $codigo = $this->generarCodigo(
                $factor->nombre
            );
            $pregunta = Pregunta::create([
                'codigo' => $codigo,
                'factor_id' => $factor->id,
                'tema_id' => $this->temaId,
                'texto' => trim($this->texto),
                'obligatoria' => (bool) $this->obligatoria,
                'es_nps' => false,
                'es_predeterminada' => false,
                'activo' => false,
            ]);
            foreach($this->tiposRespuestaSeleccionados as $tipoId){
                $pregunta->configuracionesRespuesta()->create([
                    'tipo_respuesta_id' => $tipoId,
                    'escala_id' => null
                ]);
            }
        });
        $mensaje = 'Pregunta guardada correctamente';

        $this->reset([
            'temaId',
            'texto',
            'obligatoria',
            'tiposRespuestaSeleccionados'
        ]);
        
        Flux::modal('nueva-pregunta')->close();
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }

    // confirmar cambio estado
    public function confirmarCambioEstado(int $id): void
    {
        $pregunta = Pregunta::query()
        ->findOrFail($id);

        $this->preguntaEstadoId = $pregunta->id;
        $this->nombrePreguntaEstado = $pregunta->texto;
        $this->nuevoEstadoPregunta = !(bool) $pregunta->activo;

        Flux::modal('confirmar-estado-pregunta')->show();
    }

    // cambiar estado
    public function cambiarEstadoPregunta(): void
    {
        if($this->preguntaEstadoId === null){
            return;
        }
        $pregunta = Pregunta::query()
        ->findOrFail($this->preguntaEstadoId);
        $nuevoEstado = !(bool) $pregunta->activo;
        $pregunta->activo = $nuevoEstado;
        $pregunta->save();
        $mensaje = $nuevoEstado
        ? 'Pregunta activada correctamente'
        : 'Pregunta desactivada correctamente';
        $this->reset([
            'preguntaEstadoId',
            'nombrePreguntaEstado',
            'nuevoEstadoPregunta'
        ]);
        Flux::modal('confirmar-estado-pregunta')->close();
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
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

        $tiposRespuesta = TipoRespuesta::query()
            ->orderBy('id')
            ->get();

        return view('livewire.administracion.preguntas', [
            'factores' => $factores,
            'factorActual' => $factorActual,
            'temas' => $temas,
            'estadisticas' => $estadisticas,
            'totalPreguntas' => $factores->sum('preguntas_count'),
            'tiposRespuesta' => $tiposRespuesta
        ]);
    }
}
