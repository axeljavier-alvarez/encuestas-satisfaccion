<?php

namespace App\Livewire\Administracion;

use App\Models\Plantilla;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pregunta;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Plantillas extends Component
{
    use WithPagination;

    #[Url]
    public string $buscar = '';

    public bool $mostrarModalPlantilla = false;

    public ?int $plantillaId = null;
    public string $codigoPlantilla = '';
    public string $nombrePlantilla = '';
    public string $descripcionPlantilla = '';

    public ?int $plantillaEstadoId = null;
    public string $nombrePlantillaEstado = '';
    public bool $nuevoEstadoPlantilla = false;
    // modal de asignación
    public bool $mostrarModalPreguntas = false;
    // plantilla elegida
    public ?int $plantillaSeleccionadaId = null;

    // IDs en orden de selección
    public array $preguntasSeleccionadas = [];
    // tipo elegido de cada pregunta
    public array $tiposRespuestaSeleccionados = [];
    // busqueda dentro de banco
    public string $buscarPregunta = '';

    public function crearPlantilla(): void
    {
        $this->limpiarFormulario();
        $this->mostrarModalPlantilla = true;
    }

    public function editar(int $plantillaId): void
    {
        $plantilla = Plantilla::findOrFail($plantillaId);

        $this->limpiarFormulario();

        $this->plantillaId = $plantilla->id;
        $this->codigoPlantilla = $plantilla->codigo;
        $this->nombrePlantilla = $plantilla->nombre;
        $this->descripcionPlantilla = $plantilla->descripcion ?? '';

        $this->mostrarModalPlantilla = true;
    }

    public function guardarPlantilla(): void
    {
        $datos = $this->validate([
            'codigoPlantilla' => [
                'required',
                'string',
                'max:10',
                Rule::unique('plantillas', 'codigo')
                    ->ignore($this->plantillaId),
            ],
            'nombrePlantilla' => [
                'required',
                'string',
                'max:150',
            ],
            'descripcionPlantilla' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $esEdicion = $this->plantillaId !== null;

        $valores = [
            'codigo' => trim($datos['codigoPlantilla']),
            'nombre' => trim($datos['nombrePlantilla']),
            'descripcion' => $datos['descripcionPlantilla'] ?? null,
        ];

        if ($esEdicion) {
            $plantilla = Plantilla::findOrFail($this->plantillaId);
            $plantilla->update($valores);
        } else {
            Plantilla::create($valores);
        }

        $this->cerrarModalPlantilla();

        session()->flash(
            'mensaje',
            $esEdicion
                ? 'La plantilla fue actualizada correctamente.'
                : 'La plantilla fue creada correctamente.'
        );
    }

    public function limpiarFormulario(): void
    {
        $this->reset([
            'plantillaId',
            'codigoPlantilla',
            'nombrePlantilla',
            'descripcionPlantilla',
        ]);

        $this->resetValidation();
    }

    public function cerrarModalPlantilla(): void
    {
        $this->mostrarModalPlantilla = false;
        $this->limpiarFormulario();
    }

    public function updatedBuscar(): void
    {
        $this->resetPage();
    }


    // cambiar estado
    public function confirmarCambioEstado(int $plantillaId)
    {
        $plantilla = Plantilla::findOrFail($plantillaId);
        $this->plantillaEstadoId = $plantilla->id;
        $this->nombrePlantillaEstado = $plantilla->nombre;
        $this->nuevoEstadoPlantilla = !$plantilla->activo;

        $this->modal('confirmar-estado-plantilla')->show();
    }

    public function cambiarEstadoPlantilla(): void
    {
        if (!$this->plantillaEstadoId) {
            return;
        }
        $plantilla = Plantilla::findOrFail($this->plantillaEstadoId);
        $plantilla->activo = $this->nuevoEstadoPlantilla;
        $plantilla->save();
        $mensaje = $this->nuevoEstadoPlantilla
            ? 'La plantilla fue activada correctamente.'
            : 'La plantilla fue desactivada correctamente.';
        $this->modal('confirmar-estado-plantilla')->close();
        $this->plantillaEstadoId = null;
        $this->nombrePlantillaEstado = '';
        session()->flash('mensaje', $mensaje);
    }

    // obtener preguntas predeterminadas

    private function obtenerPredeterminadas(): array
    {
        return Pregunta::query()
            ->where('activo', true)
            ->where('es_predeterminada', true)
            ->orderBy('id')
            ->pluck('id')
            ->map(fn($id) => (int) $id)
            ->all();
    }

    // metodo para abrir el modal
    public function verPreguntas(): void
    {
        // Limpiar los datos de la asignación anterior
        $this->reset([
            'plantillaSeleccionadaId',
            'preguntasSeleccionadas',
            'tiposRespuestaSeleccionados',
            'buscarPregunta',
        ]);

        $this->resetValidation();

        // Cargar únicamente las preguntas predeterminadas activas
        $this->preguntasSeleccionadas = $this->obtenerPredeterminadas();

        // Abrir el modal
        $this->mostrarModalPreguntas = true;
    }

    // metodo para cerrar el modal
    public function cerrarModalPreguntas(): void
    {
        $this->mostrarModalPreguntas = false;

        $this->reset([
            'plantillaSeleccionadaId',
            'preguntasSeleccionadas',
            'tiposRespuestaSeleccionados',
            'buscarPregunta',
        ]);

        $this->resetValidation();
    }
    // agregar y quitar preguntas
    public function alternarPregunta(int $preguntaId): void
    {
        $this->resetValidation();

        $pregunta = Pregunta::query()
            ->where('activo', true)
            ->findOrFail($preguntaId);

        // No permitir modificar predeterminadas
        if ($pregunta->es_predeterminada) {
            return;
        }

        // Quitar pregunta seleccionada
        if (in_array($preguntaId, $this->preguntasSeleccionadas, true)) {

            $this->preguntasSeleccionadas = array_values(
                array_diff($this->preguntasSeleccionadas, [$preguntaId])
            );

            unset($this->tiposRespuestaSeleccionados[$preguntaId]);

            return;
        }

        // Contar únicamente preguntas normales
        $cantidadNormales = Pregunta::query()
            ->whereIn('id', $this->preguntasSeleccionadas)
            ->where('es_predeterminada', false)
            ->count();

        if ($cantidadNormales >= 8) {
            $this->addError(
                'preguntasSeleccionadas',
                'Solamente puede seleccionar 8 preguntas adicionales.'
            );

            return;
        }

        $this->preguntasSeleccionadas[] = $preguntaId;
    }


    public function guardarPreguntas(): void
    {
        $this->resetValidation();

        // 1. Validar plantilla
        $this->validate([
            'plantillaSeleccionadaId' => [
                'required',
                'integer',
                'exists:plantillas,id',
            ],
        ], [
            'plantillaSeleccionadaId.required' =>
            'Debe seleccionar una plantilla de evaluación.',
        ]);

        // 2. Obtener predeterminadas actuales
        $predeterminadas = $this->obtenerPredeterminadas();

        if (count($predeterminadas) !== 2) {
            $this->addError(
                'preguntasSeleccionadas',
                'Debe haber exactamente 2 preguntas predeterminadas activas.'
            );
            return;
        }

        // 3. Obtener los IDs seleccionados
        $ids = array_map('intval', $this->preguntasSeleccionadas);

        if (count($ids) !== count(array_unique($ids))) {
            $this->addError(
                'preguntasSeleccionadas',
                'No puede seleccionar preguntas duplicadas.'
            );
            return;
        }

        // 4. Comprobar que estén las dos predeterminadas
        foreach ($predeterminadas as $id) {
            if (!in_array($id, $ids, true)) {
                $this->addError(
                    'preguntasSeleccionadas',
                    'Debe incluir las 2 preguntas predeterminadas.'
                );
                return;
            }
        }

        // 5. Separar las preguntas normales
        $normales = array_values(
            array_diff($ids, $predeterminadas)
        );

        if (count($normales) !== 8) {
            $this->addError(
                'preguntasSeleccionadas',
                'El campo preguntas seleccionadas debe contener 8 elementos.'
            );
            return;
        }

        // 6. Validar el total
        if (count($ids) !== 10) {
            $this->addError(
                'preguntasSeleccionadas',
                'La plantilla debe contener exactamente 10 preguntas.'
            );
            return;
        }

        // 7. Consultar preguntas activas y sus tipos permitidos
        $preguntas = Pregunta::query()
            ->with('tiposRespuesta')
            ->where('activo', true)
            ->whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        if ($preguntas->count() !== 10) {
            $this->addError(
                'preguntasSeleccionadas',
                'Todas las preguntas deben estar activas.'
            );
            return;
        }

        // 8. Preparar los datos de la tabla pivote
        $datosPivot = [];

        foreach ($ids as $indice => $preguntaId) {

            $pregunta = $preguntas->get($preguntaId);

            $tiposDisponibles = $pregunta->tiposRespuesta
                ->pluck('id')
                ->map(fn($id) => (int) $id)
                ->all();

            if (count($tiposDisponibles) === 0) {
                $this->addError(
                    'tiposRespuestaSeleccionados',
                    "La pregunta #{$preguntaId} no tiene tipos de respuesta configurados."
                );
                return;
            }

            // Un tipo: asignación automática
            // Varios tipos: selección obligatoria
            $tipoSeleccionado = count($tiposDisponibles) === 1
                ? $tiposDisponibles[0]
                : (int) ($this->tiposRespuestaSeleccionados[$preguntaId] ?? 0);

            if (!in_array($tipoSeleccionado, $tiposDisponibles, true)) {
                $this->addError(
                    'tiposRespuestaSeleccionados',
                    "Seleccione un tipo de respuesta válido para la pregunta #{$preguntaId}."
                );
                return;
            }

            $datosPivot[$preguntaId] = [
                'orden' => $indice + 1,
                'tipo_respuesta_id' => $tipoSeleccionado,
            ];
        }

        // 9. Guardar
        DB::transaction(function () use ($datosPivot) {

            $plantilla = Plantilla::query()
                ->lockForUpdate()
                ->findOrFail($this->plantillaSeleccionadaId);

            if ($plantilla->preguntas()->exists()) {
                throw ValidationException::withMessages([
                    'plantillaSeleccionadaId' =>
                    'Esta plantilla ya tiene preguntas asignadas.',
                ]);
            }

            $plantilla->preguntas()->sync($datosPivot);
        });

        // 10. Limpiar y cerrar modal
        $this->cerrarModalPreguntas();

        session()->flash(
            'mensaje',
            'Las 10 preguntas fueron asignadas correctamente.'
        );
    }


    public function render()
    {
        $plantillas = Plantilla::query()
            ->when($this->buscar !== '', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery
                        ->where('codigo', 'like', '%' . $this->buscar . '%')
                        ->orWhere('nombre', 'like', '%' . $this->buscar . '%');
                });
            })
            ->latest('id')
            ->paginate(10);
        $plantillasDisponibles = Plantilla::query()
            ->doesntHave('preguntas')
            ->orderBy('nombre')
            ->get();

        $preguntasActivas = Pregunta::query()
            ->with(['factor', 'tema', 'tiposRespuesta'])
            ->where('activo', true)
            ->when($this->buscarPregunta !== '', function ($query) {
                $query->where(
                    'texto',
                    'like',
                    '%' . $this->buscarPregunta . '%'
                );
            })
            ->orderByDesc('es_predeterminada')
            ->orderBy('id')
            ->get();

        $preguntasSeleccionadasDetalle = Pregunta::query()
            ->with('tiposRespuesta')
            ->whereIn('id', $this->preguntasSeleccionadas)
            ->get()
            ->sortBy(
                fn($pregunta) => array_search(
                    $pregunta->id,
                    $this->preguntasSeleccionadas
                )
            )
            ->values();
        // preguntas normales
        $cantidadNormales = $preguntasSeleccionadasDetalle
            ->where('es_predeterminada', false)
            ->count();
        // preguntas predeterminadas
        $cantidadPredeterminadas = $preguntasSeleccionadasDetalle
            ->where('es_predeterminada', true)
            ->count();
        // total seleccionadas
        $cantidadTotal = count($this->preguntasSeleccionadas);
        // validar tipos de respuesta
        $tiposValidos = $preguntasSeleccionadasDetalle->every(
            function ($pregunta) {
                $tipos = $pregunta->tiposRespuesta;
                if ($tipos->isEmpty()) {
                    return false;
                }
                // si solo tiene 1 tipo se asisgna automaticamente
                if ($tipos->count() === 1) {
                    return true;
                }
                // Si tiene varios, debe seleccionar uno permitido
                return $tipos->contains(
                    'id',
                    (int) ($this->tiposRespuestaSeleccionados[$pregunta->id] ?? 0)
                );
            }
        );
        return view('livewire.administracion.plantillas', [
            'plantillas' => $plantillas,
            'totalPlantillas' => Plantilla::count(),
            'totalActivas' => Plantilla::where('activo', true)->count(),
            'totalInactivas' => Plantilla::where('activo', false)->count(),
            'plantillasDisponibles' => $plantillasDisponibles,
            'preguntasActivas' => $preguntasActivas,
            'preguntasSeleccionadasDetalle' => $preguntasSeleccionadasDetalle,
            // contadores
            'cantidadNormales' => $cantidadNormales,
            'cantidadPredeterminadas' => $cantidadPredeterminadas,
            'cantidadTotal' => $cantidadTotal,
            // validacion visual del botón
            'tiposValidos' => $tiposValidos
        ]);
    }
}
