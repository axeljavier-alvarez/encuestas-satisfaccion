<?php

namespace App\Livewire\Administracion;

use App\Models\{Plantilla, User};
use App\Traits\{DataTable, Interact};
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use Flux\Flux;
use Illuminate\Support\Facades\DB;

class Plantillas extends Component
{
    use DataTable, Interact;
    public ?int $plantillaId = null;
    public string $nombre = '';
    public string $descripcion = '';

    // propiedades para cambiar el estado de la plantilla
    public ?int $plantillaEstadoId = null;
    public string $nombrePlantillaEstado = '';
    public string $estadoActualPlantilla = '';
    public string $nuevoEstadoPlantilla = '';

    // estados disponibles
    public array $estadosDisponibles = [
        'borrador' => 'Borrador',
        'publicada' => 'Publicada',
        'inactiva' => 'Inactiva',
    ];

    // asignador seleccionado para la plantilla
    public ?int $asignadorId = null;

    // contenido de la tabla
    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'nombre', 'label' => 'Nombre'],
        ['index' => 'descripcion', 'label' => 'Descripción'],
        ['index' => 'usuarios.name', 'label' => 'Asignador'],
        ['index' => 'estado', 'label' => 'Estado'],
        ['index' => 'actions', 'label' => 'Acciones'],
    ];
    // columnas que permiten ordenamiento
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
    /* obtener las plantillas para la tabla */
    #[Computed]
    public function rows()
    {
        $query = Plantilla::query()->with('usuarios');

        // aplicar búsqueda, filtros y ordenamiento
        $query->filterAdvance($this->headers, [
            'search' => $this->search,
            'filters' => $this->processFilters(),
            'sort' => [
                'field' => $this->sortBy,
                'direction' => $this->sortDirection,
            ],
        ]);

        // priorizar las plantillas publicadas
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

    /* limpiar los datos del formulario */
    public function resetData(): void
    {
        $this->reset([
            'plantillaId',
            'nombre',
            'descripcion',
            'asignadorId',
        ]);
        $this->resetValidation();
    }

    public function abrirNuevaPlantilla(): void
    {
        $this->resetData();
        Flux::modal('nueva-plantilla')->show();
    }

    public function cerrarNuevaPlantilla(): void
    {
        $this->resetData();
        Flux::modal('nueva-plantilla')->close();
    }
    /**
     * Genera un código consecutivo para una plantilla
     * según la serie institucional seleccionada.
     *
     * @param int $serie Serie a la que pertenece la plantilla.
     * @return string Código generado con el formato SB-XXX.
     * @throws \RuntimeException Si la serie alcanzó su límite.
     */
    private function generarCodigo(int $serie): string
    {
        // Definir el rango de numeración de la serie.
        // Ejemplo: serie 6, rango del 600 al 699.
        $inicio = $serie * 100;
        $fin = $inicio + 99;

        // Obtener el número más alto registrado en la serie.
        $ultimoNumero = Plantilla::query()

            // Buscar los códigos que pertenecen a la serie seleccionada.
            ->where('codigo', 'like', "SB-{$serie}%")

            // Obtener únicamente los valores de la columna código.
            ->pluck('codigo')

            // Filtrar los códigos que cumplen con el formato SB-XXX
            // y pertenecen exactamente a la serie seleccionada.
            ->filter(function ($codigo) use ($serie) {
                return preg_match(
                    "/^SB-{$serie}[0-9]{2}$/",
                    $codigo
                );
            })

            // Eliminar el prefijo SB- y convertir el código a entero.
            // Ejemplo: SB-608 se convierte en 608.
            ->map(fn($codigo) => (int) substr($codigo, 3))

            // Obtener el número más alto de los códigos encontrados.
            ->max();

        // Si no existen registros en la serie, utilizar el número inicial.
        // De lo contrario, incrementar en uno el último número registrado.
        $siguiente = $ultimoNumero === null
            ? $inicio
            : $ultimoNumero + 1;

        // Verificar que el nuevo número no exceda el límite de la serie.
        if ($siguiente > $fin) {
            throw new \RuntimeException(
                'La serie seleccionada no tiene códigos disponibles.'
            );
        }

        // Retornar el código consecutivo con el prefijo institucional.
        return 'SB-' . $siguiente;
    }

    public function guardar(): void
    {
        // Validar los datos del formulario
        $this->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('plantillas', 'nombre')
                    ->ignore($this->plantillaId),
            ],

            'descripcion' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'asignadorId' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('rol', 'asignador')
                    ->where('activo', true),
            ],
        ], [
            'asignadorId.required' =>
            'Seleccione un asignador.',

            'asignadorId.exists' =>
            'El asignador seleccionado no está disponible.',
        ], [
            'nombre' => 'nombre de la plantilla',
            'descripcion' => 'descripción',
            'asignadorId' => 'asignador',
        ]);

        $mensaje = DB::transaction(function () {
            $datos = [
                'nombre' => trim($this->nombre),
                'descripcion' => trim($this->descripcion) ?: null,
            ];
            if ($this->plantillaId !== null) {
                // editar plantilla
                $plantilla = Plantilla::findOrFail($this->plantillaId);
                $plantilla->update($datos);
                $mensaje = 'Plantilla actualizada correctamente';
            } else {
                $plantilla = Plantilla::create([
                    ...$datos,
                    'codigo' => $this->generarCodigo(),
                    'estado' => 'borrador',
                ]);
                $mensaje = 'Plantilla guardada correctamente';
            }
            // asociar al asignador seleccionado
            $plantilla->usuarios()->sync([
                $this->asignadorId,
            ]);
            return $mensaje;
        });
        // cerrar modal
        Flux::modal('nueva-plantilla')->close();
        $this->resetData();
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }

    public function editar(int $id): void
    {
        // limpiar datos anteriores
        $this->resetData();
        $plantilla = Plantilla::query()
            ->with('usuarios')
            ->findOrFail($id);
        // cargar datos formulario
        $this->plantillaId = $plantilla->id;
        $this->nombre = $plantilla->nombre;
        $this->descripcion = $plantilla->descripcion ?? '';
        // recuperar el asignador asociado
        $this->asignadorId = $plantilla->usuarios
            ->firstWhere('rol', 'asignador')
            ?->id;
        // Abrir el modal
        Flux::modal('nueva-plantilla')->show();
    }

    /* abrir modal para cambiar el estado */
    public function confirmarCambioEstado(int $id): void
    {
        $this->resetValidation();

        // buscar la plantilla seleccionada
        $plantilla = Plantilla::findOrFail($id);

        // recuperar los datos de la plantilla
        $this->plantillaEstadoId = $plantilla->id;
        $this->nombrePlantillaEstado = $plantilla->nombre;
        $this->estadoActualPlantilla = $plantilla->estado;

        // seleccionar inicialmente el estado actual
        $this->nuevoEstadoPlantilla = $plantilla->estado;

        // abrir modal
        Flux::modal('cambiar-estado-plantilla')->show();
    }
    /* actualizar el estado de la plantilla */
    public function cambiarEstadoPlantilla(): void
    {
        if ($this->plantillaEstadoId === null) {
            return;
        }

        // validar el estado seleccionado
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
            'nuevoEstadoPlantilla' => 'estado de la plantilla',
        ]);

        // buscar la plantilla
        $plantilla = Plantilla::findOrFail(
            $this->plantillaEstadoId
        );

        // verificar si realmente cambió el estado
        // if ($plantilla->estado === $this->nuevoEstadoPlantilla) {
        //     $this->addError(
        //         'nuevoEstadoPlantilla',
        //         'Seleccione un estado diferente al actual.'
        //     );

        //     return;
        // }

        // actualizar el estado
        $plantilla->update([
            'estado' => $this->nuevoEstadoPlantilla,
        ]);

        // cerrar modal y limpiar propiedades
        $this->cerrarCambioEstado();

        // mostrar mensaje
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: 'Estado de la plantilla actualizado correctamente',
            tipo: 'success'
        );
    }
    /* cerrar modal de cambio de estado */
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



    public function render()
    {
        $estadisticas = Plantilla::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw("
            SUM(CASE WHEN estado = 'borrador' THEN 1 ELSE 0 END)
            as borradores
        ")
            ->selectRaw("
            SUM(CASE WHEN estado = 'publicada' THEN 1 ELSE 0 END)
            as publicadas
        ")
            ->selectRaw("
            SUM(CASE WHEN estado = 'inactiva' THEN 1 ELSE 0 END)
            as inactivas
        ")
            ->first();
        // obtener asignadores activos
        $asignadores = User::query()
            ->where('rol', 'asignador')
            ->where('activo', true)
            ->orderBy('name')
            ->get();

        return view('livewire.administracion.plantillas', [
            'estadisticas' => $estadisticas,
            'asignadores' => $asignadores
        ]);
    }
}
