<?php

namespace App\Livewire\Administracion;

use App\Models\{Plantilla, User, Dependencia, Programa};
use App\Traits\{DataTable, Interact};
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Flux\Flux;

class Plantillas extends Component
{
    use DataTable, Interact;

    public ?int $plantillaId = null;
    public string $nombre = '';
    public string $descripcion = '';
    public ?int $asignadorId = null;

    // Dependencia y programa seleccionados
    public ?int $dependenciaId = null;
    public ?int $programaId = null;

    // Configuración de las series institucionales
    private const SERIES = [
        4  => ['serie' => 1, 'prefijo' => 'DDS'],
        5  => ['serie' => 2, 'prefijo' => 'DEC'],
        8  => ['serie' => 4, 'prefijo' => 'SAS'],
        41 => ['serie' => 5, 'prefijo' => 'Convivencia Social'],
        6  => ['serie' => 6, 'prefijo' => 'DMM'],
    ];

    // Propiedades para cambiar el estado
    public ?int $plantillaEstadoId = null;
    public string $nombrePlantillaEstado = '';
    public string $estadoActualPlantilla = '';
    public string $nuevoEstadoPlantilla = '';

    public array $estadosDisponibles = [
        'borrador' => 'Borrador',
        'publicada' => 'Publicada',
        'inactiva' => 'Inactiva',
    ];

    // Contenido de la tabla
    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'nombre', 'label' => 'Nombre'],
        ['index' => 'descripcion', 'label' => 'Descripción'],
        ['index' => 'usuarios.name', 'label' => 'Asignador'],
        ['index' => 'estado', 'label' => 'Estado'],
        ['index' => 'actions', 'label' => 'Acciones'],
    ];

    // Columnas que permiten ordenamiento
    protected function tableSortableColumns(): array
    {
        return [
            'id',
            'codigo',
            'nombre',
            'estado',
        ];
    }

    // Columnas disponibles para filtros
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

    /**
     * Obtener las plantillas para la tabla.
     */
    #[Computed]
    public function rows()
    {
        $query = Plantilla::query()->with('usuarios');

        $query->filterAdvance($this->headers, [
            'search' => $this->search,
            'filters' => $this->processFilters(),
            'sort' => [
                'field' => $this->sortBy,
                'direction' => $this->sortDirection,
            ],
        ]);

        // Priorizar las plantillas publicadas
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

    /**
     * Obtener todas las dependencias registradas.
     */
    #[Computed]
    public function dependenciasDisponibles(): Collection
    {
        return Dependencia::query()
            ->orderBy('nombre')
            ->get();
    }

    /**
     * Normalizar los nombres para facilitar su comparación.
     */
    private function normalizarNombre(string $nombre): string
    {
        return Str::of($nombre)
            ->ascii()
            ->lower()
            ->replaceMatches('/[^a-z0-9]+/', ' ')
            ->squish()
            ->toString();
    }

    /**
     * Obtener los programas que todavía no tienen plantilla.
     */
    #[Computed]
    public function programasDisponibles(): Collection
    {
        if ($this->dependenciaId === null) {
            return collect();
        }

        // Obtener programas activos de la dependencia
        $programas = Programa::query()
            ->where('dependencia_id', $this->dependenciaId)
            ->where('estado', 'A')
            ->orderBy('nombre')
            ->get();

        // Obtener la serie institucional correspondiente
        $configuracion = self::SERIES[$this->dependenciaId] ?? null;

        // Si no tiene serie, mostrar sus programas
        if ($configuracion === null) {
            return $programas
                ->unique('nombre')
                ->values();
        }

        // Obtener nombres de plantillas de la misma serie
        $nombresUtilizados = Plantilla::query()
            ->where(
                'codigo',
                'like',
                "SB-{$configuracion['serie']}%"
            )
            ->pluck('nombre')
            ->map(
                fn($nombre) =>
                $this->normalizarNombre($nombre)
            );

        // Excluir programas que ya tienen una plantilla
        return $programas
            ->reject(function ($programa) use ($nombresUtilizados) {

                $nombrePrograma = $this->normalizarNombre(
                    $programa->nombre
                );

                return $nombresUtilizados->contains(
                    fn($nombrePlantilla) =>
                    str_contains(
                        ' ' . $nombrePlantilla . ' ',
                        ' ' . $nombrePrograma . ' '
                    )
                );
            })
            // Evitar opciones repetidas por nombre
            ->unique(
                fn($programa) =>
                $this->normalizarNombre($programa->nombre)
            )
            ->values();
    }

    /**
     * Limpiar el programa al cambiar de dependencia.
     */
    public function updatedDependenciaId(): void
    {
        $this->programaId = null;

        unset($this->programasDisponibles);

        $this->resetValidation();
    }

    /**
     * Limpiar los datos del formulario.
     */
    public function resetData(): void
    {
        $this->reset([
            'plantillaId',
            'nombre',
            'descripcion',
            'asignadorId',
            'dependenciaId',
            'programaId',
        ]);

        unset($this->programasDisponibles);

        $this->resetValidation();
    }

    /**
     * Abrir el modal para crear una plantilla.
     */
    public function abrirNuevaPlantilla(): void
    {
        $this->resetData();

        Flux::modal('nueva-plantilla')->show();
    }

    /**
     * Cerrar el modal de plantillas.
     */
    public function cerrarNuevaPlantilla(): void
    {
        $this->resetData();

        Flux::modal('nueva-plantilla')->close();
    }

    /**
     * Generar un código consecutivo según la serie.
     *
     * Ejemplo: SB-112, SB-113, SB-114.
     */
    private function generarCodigo(int $serie): string
    {
        $inicio = $serie * 100;
        $fin = $inicio + 99;

        $ultimoNumero = Plantilla::query()
            ->where('codigo', 'like', "SB-{$serie}%")
            ->pluck('codigo')
            ->filter(function ($codigo) use ($serie) {
                return preg_match(
                    "/^SB-{$serie}[0-9]{2}$/",
                    $codigo
                );
            })
            ->map(
                fn($codigo) =>
                (int) substr($codigo, 3)
            )
            ->max();

        $siguiente = $ultimoNumero === null
            ? $inicio
            : $ultimoNumero + 1;

        if ($siguiente > $fin) {
            throw ValidationException::withMessages([
                'dependenciaId' =>
                'La dependencia no tiene códigos disponibles.',
            ]);
        }

        return 'SB-' . $siguiente;
    }

    /**
     * Guardar o actualizar una plantilla.
     */
    public function guardar(): void
    {
        $this->asignadorId = filled($this->asignadorId)
            ? $this->asignadorId
            : null;

        $reglas = [
            'descripcion' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'asignadorId' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
                    ->where('rol', 'asignador')
                    ->where('activo', true),
            ],
        ];

        if ($this->plantillaId === null) {

            // Validaciones para crear
            $reglas['dependenciaId'] = [
                'required',
                'integer',
                Rule::exists('dependencias', 'id'),
            ];

            $reglas['programaId'] = [
                'required',
                'integer',
                Rule::exists('programas', 'id')
                    ->where(
                        'dependencia_id',
                        $this->dependenciaId
                    )
                    ->where('estado', 'A'),
            ];
        } else {

            // Validaciones para editar
            $this->nombre = trim($this->nombre);

            $reglas['nombre'] = [
                'required',
                'string',
                'max:150',
                Rule::unique('plantillas', 'nombre')
                    ->ignore($this->plantillaId),
            ];
        }

        $this->validate($reglas, [
            'dependenciaId.required' =>
            'Seleccione una dependencia.',

            'dependenciaId.exists' =>
            'La dependencia seleccionada no existe.',

            'programaId.required' =>
            'Seleccione un programa.',

            'programaId.exists' =>
            'El programa seleccionado no está disponible.',

            'nombre.required' =>
            'Ingrese el nombre de la plantilla.',

            'asignadorId.exists' =>
            'El asignador seleccionado no está disponible.',
        ]);

        $mensaje = DB::transaction(function () {

            $datos = [
                'descripcion' =>
                trim($this->descripcion) ?: null,
            ];

            if ($this->plantillaId !== null) {

                // Actualizar plantilla existente
                $plantilla = Plantilla::findOrFail(
                    $this->plantillaId
                );

                $plantilla->update([
                    ...$datos,
                    'nombre' => $this->nombre,
                ]);

                $mensaje =
                    'Plantilla actualizada correctamente';
            } else {

                // Obtener la configuración institucional
                $configuracion = self::SERIES[$this->dependenciaId] ?? null;

                if ($configuracion === null) {
                    throw ValidationException::withMessages([
                        'dependenciaId' =>
                        'Esta dependencia todavía no tiene una serie institucional configurada.',
                    ]);
                }

                // Volver a consultar los programas disponibles
                unset($this->programasDisponibles);

                // Verificar que el programa no esté utilizado
                $programa = $this->programasDisponibles
                    ->firstWhere('id', $this->programaId);

                if (! $programa) {
                    throw ValidationException::withMessages([
                        'programaId' =>
                        'El programa ya tiene una plantilla o no está disponible.',
                    ]);
                }

                // Generar código consecutivo
                $codigo = $this->generarCodigo(
                    $configuracion['serie']
                );

                // Generar nombre completo
                $nombre = implode('-', [
                    $codigo,
                    $configuracion['prefijo'],
                    trim($programa->nombre),
                ]);

                // Verificar longitud del nombre
                if (mb_strlen($nombre) > 150) {
                    throw ValidationException::withMessages([
                        'programaId' =>
                        'El nombre generado supera los 150 caracteres.',
                    ]);
                }

                // Registrar nueva plantilla
                $plantilla = Plantilla::create([
                    ...$datos,
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                    'estado' => 'borrador',
                ]);

                $mensaje =
                    'Plantilla guardada correctamente';
            }

            // Asociar o retirar el asignador
            $plantilla->usuarios()->sync(
                filled($this->asignadorId)
                    ? [$this->asignadorId]
                    : []
            );

            return $mensaje;
        });

        unset($this->rows);
        unset($this->programasDisponibles);

        Flux::modal('nueva-plantilla')->close();

        $this->resetData();

        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }

    /**
     * Cargar los datos de una plantilla existente.
     */
    public function editar(int $id): void
    {
        $this->resetData();

        $plantilla = Plantilla::query()
            ->with('usuarios')
            ->findOrFail($id);

        $this->plantillaId = $plantilla->id;
        $this->nombre = $plantilla->nombre;
        $this->descripcion = $plantilla->descripcion ?? '';

        $this->asignadorId = $plantilla->usuarios
            ->firstWhere('rol', 'asignador')
            ?->id;

        Flux::modal('nueva-plantilla')->show();
    }

    /**
     * Abrir el modal para cambiar el estado.
     */
    public function confirmarCambioEstado(int $id): void
    {
        $this->resetValidation();

        $plantilla = Plantilla::findOrFail($id);

        $this->plantillaEstadoId = $plantilla->id;
        $this->nombrePlantillaEstado = $plantilla->nombre;
        $this->estadoActualPlantilla = $plantilla->estado;
        $this->nuevoEstadoPlantilla = $plantilla->estado;

        Flux::modal('cambiar-estado-plantilla')->show();
    }

    /**
     * Actualizar el estado de una plantilla.
     */
    public function cambiarEstadoPlantilla(): void
    {
        if ($this->plantillaEstadoId === null) {
            return;
        }

        $this->validate([
            'nuevoEstadoPlantilla' => [
                'required',
                Rule::in([
                    'borrador',
                    'publicada',
                    'inactiva',
                ]),
            ],
        ], [], [
            'nuevoEstadoPlantilla' =>
            'estado de la plantilla',
        ]);

        $plantilla = Plantilla::findOrFail(
            $this->plantillaEstadoId
        );

        $plantilla->update([
            'estado' => $this->nuevoEstadoPlantilla,
        ]);

        unset($this->rows);

        $this->cerrarCambioEstado();

        $this->dispatch(
            'mostrar-mensaje',
            mensaje: 'Estado de la plantilla actualizado correctamente',
            tipo: 'success'
        );
    }

    /**
     * Cerrar el modal de cambio de estado.
     */
    public function cerrarCambioEstado(): void
    {
        $this->reset([
            'plantillaEstadoId',
            'nombrePlantillaEstado',
            'estadoActualPlantilla',
            'nuevoEstadoPlantilla',
        ]);

        $this->resetValidation();

        Flux::modal('cambiar-estado-plantilla')->close();
    }

    /**
     * Renderizar la vista.
     */
    public function render()
    {
        $estadisticas = Plantilla::query()
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

        $asignadores = User::query()
            ->where('rol', 'asignador')
            ->where('activo', true)
            ->orderBy('name')
            ->get();

        return view('livewire.administracion.plantillas', [
            'estadisticas' => $estadisticas,
            'asignadores' => $asignadores,
        ]);
    }
}
