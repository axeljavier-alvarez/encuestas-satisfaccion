<?php

namespace App\Livewire\Administracion;

use App\Models\{Factor, Pregunta, Tema, TipoRespuesta, Escala, PreguntaTipoRespuesta};
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
    // editar pregunta
    public ?int $preguntaId = null;
    // es_predeterminada
    public bool $esPredeterminada = false;
    // configuracion de respuestas
    public ?int $preguntaConfiguracionId = null;
    public ?int $escalaSeleccionada = null;
    public bool $tieneEscala = false;
    public bool $tieneOtrosTipos = false;
    public string $textoPreguntaConfiguracion = '';

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


    public function resetData(): void
    {
        $this->reset([
            'preguntaId',
            'temaId',
            'texto',
            'obligatoria',
            'tiposRespuestaSeleccionados',
            'esPredeterminada',
        ]);

        $this->resetValidation();
    }



    // abrir modal de pregunta
    public function abrirNuevaPregunta(): void
    {
        if ($this->factorSeleccionado === null) {
            return;
        }

        $this->resetData();

        Flux::modal('nueva-pregunta')->show();
    }

    public function cerrarNuevaPregunta(): void
    {
        $this->resetData();

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
        $esPredeterminada = $this->preguntaId !== null
            && Pregunta::query()
            ->where('factor_id', $this->factorSeleccionado)
            ->whereKey($this->preguntaId)
            ->where('es_predeterminada', true)
            ->exists();

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
            'obligatoria' => $esPredeterminada
                ? ['exclude']
                : ['required', Rule::in(['0', '1'])],

            'tiposRespuestaSeleccionados' => $esPredeterminada
                ? ['exclude']
                : ['required', 'array', 'min:1'],

            'tiposRespuestaSeleccionados.*' => $esPredeterminada
                ? ['exclude']
                : [
                    'required',
                    'integer',
                    'distinct',
                    Rule::exists('tipos_respuesta', 'id'),
                ],
        ]);

        $mensaje = DB::transaction(function () {
            if ($this->preguntaId !== null) {
                $pregunta = Pregunta::query()
                    ->where('factor_id', $this->factorSeleccionado)
                    ->findOrFail($this->preguntaId);

                // Campos que siempre pueden editarse
                $datos = [
                    'tema_id' => $this->temaId,
                    'texto' => trim($this->texto),
                ];

                // Solo preguntas NO predeterminadas
                if (! $pregunta->es_predeterminada) {
                    $datos['obligatoria'] = (bool) $this->obligatoria;
                }

                $pregunta->update($datos);

                $mensaje = 'Pregunta actualizada correctamente';
            } else {
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
                $mensaje = 'Pregunta guardada correctamente';
            }

            if (! $pregunta->es_predeterminada) {
                // sincronizar tipos de respuesta
                $tiposSeleccionados = array_map(
                    'intval',
                    $this->tiposRespuestaSeleccionados
                );
                // eliminar tipos que fueron desmarcados
                $pregunta->configuracionesRespuesta()
                    ->whereNotIn('tipo_respuesta_id', $tiposSeleccionados)
                    ->delete();
                // agregar tipos nuevos sin duplicar los existentes
                foreach ($tiposSeleccionados as $tipoId) {
                    $pregunta->configuracionesRespuesta()
                        ->firstOrCreate(
                            ['tipo_respuesta_id' => $tipoId],
                            ['escala_id' => null]
                        );
                }
            }

            return $mensaje;

            // foreach($this->tiposRespuestaSeleccionados as $tipoId){
            //     $pregunta->configuracionesRespuesta()->create([
            //         'tipo_respuesta_id' => $tipoId,
            //         'escala_id' => null
            //     ]);
            // }
        });
        $this->resetData();
        Flux::modal('nueva-pregunta')->close();
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }

    public function editar(int $id): void
    {
        if ($this->factorSeleccionado === null) {
            return;
        }
        $this->resetData();
        $pregunta = Pregunta::query()
            ->with('tiposRespuesta')
            ->where('factor_id', $this->factorSeleccionado)
            ->findOrFail($id);
        $this->preguntaId = $pregunta->id;
        $this->temaId = $pregunta->tema_id;
        $this->texto = $pregunta->texto;
        $this->obligatoria = $pregunta->obligatoria ? '1' : '0';
        $this->esPredeterminada = (bool) $pregunta->es_predeterminada;

        $this->tiposRespuestaSeleccionados = $pregunta
            ->tiposRespuesta
            ->pluck('id')
            ->map(fn($id) => (string) $id)
            ->all();
        Flux::modal('nueva-pregunta')->show();
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
        if ($this->preguntaEstadoId === null) {
            return;
        }
        $pregunta = Pregunta::query()
            ->findOrFail($this->preguntaEstadoId);

        if ($pregunta->es_predeterminada) {
            return;
        }

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


    /**
     * Abre el modal para configurar las respuestas de una pregunta.
     *
     * Identifica los tipos de respuesta asociados a la pregunta,
     * recupera la escala previamente configurada (si existe)
     * y determina si hay otros tipos pendientes de configurar.
     */
    public function configurarRespuestas(int $id): void
    {
        // Verificar que exista un factor seleccionado
        if ($this->factorSeleccionado === null) {
            return;
        }

        // Limpiar los datos de configuraciones anteriores
        $this->reset([
            'preguntaConfiguracionId',
            'escalaSeleccionada',
            'tieneEscala',
            'tieneOtrosTipos',
            'textoPreguntaConfiguracion'
        ]);

        // Limpiar los errores de validación anteriores
        $this->resetValidation();

        // Buscar la pregunta y cargar sus configuraciones
        // junto con los tipos de respuesta asociados
        $pregunta = Pregunta::query()
            ->with('configuracionesRespuesta.tipoRespuesta')
            ->where('factor_id', $this->factorSeleccionado)
            ->findOrFail($id);

        // Obtener las configuraciones de respuesta de la pregunta
        $configuraciones = $pregunta->configuracionesRespuesta;

        // Buscar si la pregunta tiene el tipo de respuesta
        // "Escala de 0 a 10"
        $configuracionEscala = $configuraciones->first(
            fn($config) =>
            $config->tipoRespuesta?->nombre === 'Escala de 0 a 10'
        );

        // Guardar el ID y el texto de la pregunta seleccionada
        $this->preguntaConfiguracionId = $pregunta->id;
        $this->textoPreguntaConfiguracion = $pregunta->texto;

        // Indicar si la pregunta utiliza una escala numérica
        $this->tieneEscala = $configuracionEscala !== null;

        // Verificar si existen otros tipos de respuesta
        // diferentes de "Escala de 0 a 10" y "Texto abierto"
        // Por ejemplo: Selección única o Selección múltiple
        $this->tieneOtrosTipos = $configuraciones->contains(
            fn($config) =>
            ! in_array(
                $config->tipoRespuesta?->nombre,
                ['Escala de 0 a 10', 'Texto abierto'],
                true
            )
        );

        // Si la pregunta ya tiene una escala configurada,
        // recuperar su ID para mostrarla seleccionada en el formulario
        if ($configuracionEscala?->escala_id !== null) {
            $this->escalaSeleccionada = (int) $configuracionEscala->escala_id;
        }

        // Depuración: permite verificar los tipos de respuesta
        // y la escala recuperada desde la base de datos
        // dd([
        //     'pregunta_id' => $pregunta->id,
        //     'configuraciones' => $configuraciones->map(fn($config) => [
        //         'tipo' => $config->tipoRespuesta?->nombre,
        //         'escala_id' => $config->escala_id,
        //     ])->all(),
        //     'escala_seleccionada' => $this->escalaSeleccionada,
        // ]);

        // Abrir el modal de configuración de respuestas
        Flux::modal('configurar-respuestas')->show();
    }

    /**
     * Guarda la escala seleccionada para una pregunta.
     *
     * Valida que la escala exista en la base de datos
     * y actualiza el campo escala_id de la configuración
     * correspondiente al tipo de respuesta "Escala de 0 a 10".
     */
    public function guardarConfiguracionRespuestas(): void
    {
        // Verificar que exista una pregunta y un factor seleccionado,
        // y que la pregunta tenga el tipo de respuesta escala
        if (
            $this->preguntaConfiguracionId === null ||
            $this->factorSeleccionado === null ||
            ! $this->tieneEscala
        ) {
            return;
        }

        // Validar que se haya seleccionado una escala válida
        // y que exista en la tabla escalas
        $this->validate([
            'escalaSeleccionada' => [
                'required',
                'integer',
                Rule::exists('escalas', 'id'),
            ],
        ]);

        // Buscar la pregunta dentro del factor seleccionado
        $pregunta = Pregunta::query()
            ->where('factor_id', $this->factorSeleccionado)
            ->findOrFail($this->preguntaConfiguracionId);

        // Obtener el tipo de respuesta "Escala de 0 a 10"
        $tipoEscala = TipoRespuesta::query()
            ->where('nombre', 'Escala de 0 a 10')
            ->firstOrFail();

        // Buscar la configuración correspondiente a ese tipo
        // de respuesta dentro de la pregunta seleccionada
        $configuracion = $pregunta->configuracionesRespuesta()
            ->where('tipo_respuesta_id', $tipoEscala->id)
            ->firstOrFail();

        // Actualizar únicamente la escala seleccionada
        // en la tabla pregunta_tipo_respuesta
        $configuracion->update([
            'escala_id' => $this->escalaSeleccionada
        ]);

        // Cerrar el modal después de guardar la configuración
        Flux::modal('configurar-respuestas')->close();

        // Mostrar un mensaje de confirmación al usuario
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: 'Escala configurada correctamente',
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

        $escalas = Escala::query()
            ->whereIn('id', [1, 2])
            ->orderByRaw('CASE WHEN id = 2 THEN 0 ELSE 1 END')
            ->get();

        $escalaActual = $escalas->firstWhere('id', (int) $this->escalaSeleccionada);


        return view('livewire.administracion.preguntas', [
            'factores' => $factores,
            'factorActual' => $factorActual,
            'temas' => $temas,
            'estadisticas' => $estadisticas,
            'totalPreguntas' => $factores->sum('preguntas_count'),
            'tiposRespuesta' => $tiposRespuesta,
            'escalas' => $escalas,
            'escalaActual' => $escalaActual
        ]);
    }
}
