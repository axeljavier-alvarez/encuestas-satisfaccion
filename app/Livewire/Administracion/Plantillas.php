<?php

namespace App\Livewire\Administracion;

use App\Models\{Plantilla, User};
use App\Traits\{DataTable, Interact};
use Livewire\Component;
use Livewire\Attributes\Computed;
use Illuminate\Validation\Rule;
use Flux\Flux;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class Plantillas extends Component
{
    use DataTable, Interact;
    public ?int $plantillaId = null;
    public string $nombre = '';
    public string $descripcion = '';

    // propiedades para activar o desactivar plantillas
    public ?int $plantillaEstadoId = null;
    public string $nombrePlantillaEstado = '';
    public bool $nuevoEstadoPlantilla  = false;

    // asignador seleccionado para la plantilla
    public ?int $asignadorId = null;

    // contenido de la tabla
    public array $headers = [
        ['index' => 'id', 'label' => '#'],
        ['index' => 'codigo', 'label' => 'Código'],
        ['index' => 'nombre', 'label' => 'Nombre'],
        ['index' => 'descripcion', 'label' => 'Descripción'],
        ['index' => 'estado', 'label' => 'Estado'],
        ['index' => 'activo', 'label' => 'Activo'],
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
            'activo',
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
            'activo',
        ];
    }
    /* obtener las plantillas para la tabla */
    #[Computed]
    public function rows()
    {
        $query = Plantilla::query();
        // aplicar busqueda, filtros y ordenamiento
        $query->filterAdvance($this->headers, [
            'search' => $this->search,
            'filters' => $this->processFilters(),
            'sort' => [
                'field' => $this->sortBy,
                'direction' => $this->sortDirection
            ]
        ]);
        // mostrar primero las plantillas activas cuando se ordena por ID
        if ($this->sortBy === 'id') {
            $query->reorder('activo', 'desc')
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
    /* generar codigo consecutivo para plantilla */
    private function generarCodigo(): string
    {
        $codigos = Plantilla::query()
            ->where('codigo', 'like', 'PLT-%')
            ->pluck('codigo');

        $ultimoNumero = $codigos
            ->map(function ($codigo) {
                if (preg_match('/^PLT-(\d+)$/', $codigo, $coincidencias)) {
                    return (int) $coincidencias[1];
                }

                return 0;
            })
            ->max() ?? 0;

        $siguiente = $ultimoNumero + 1;

        return 'PLT-' . str_pad(
            (string) $siguiente,
            3,
            '0',
            STR_PAD_LEFT
        );
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
                    'activo' => false
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
        $this->resetData();
        $plantilla = Plantilla::findOrFail($id);
        $this->plantillaId = $plantilla->id;
        $this->nombre = $plantilla->nombre;
        $this->descripcion = $plantilla->descripcion ?? '';
        // Abrir el modal
        Flux::modal('nueva-plantilla')->show();
    }

    /* mostrar confirmación antes de cambiar el estado */
    public function confirmarCambioEstado(int $id): void
    {
        $plantilla = Plantilla::findOrFail($id);
        $this->plantillaEstadoId = $plantilla->id;
        $this->nombrePlantillaEstado = $plantilla->nombre;
        $this->nuevoEstadoPlantilla = ! (bool) $plantilla->activo;
        Flux::modal('confirmar-estado-plantilla')->show();
    }
    /* activar o desactivar una plantilla */
    public function cambiarEstadoPlantilla(): void
    {
        if ($this->plantillaEstadoId === null) {
            return;
        }
        // buscar la plantilla
        $plantilla = Plantilla::findOrFail($this->plantillaEstadoId);
        // invertir estado actual
        $plantilla->activo = ! (bool) $plantilla->activo;
        $plantilla->save();
        $mensaje = $plantilla->activo
            ? 'Plantilla activada correctamente'
            : 'Plantilla desactivada correctamente';
        $this->reset([
            'plantillaEstadoId',
            'nombrePlantillaEstado',
            'nuevoEstadoPlantilla',
        ]);
        // Cerrar confirmación
        Flux::modal('confirmar-estado-plantilla')->close();
        // Mostrar mensaje
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }
    public function render()
    {
        $estadisticas = Plantilla::query()
            ->selectRaw('COUNT(*) as total')
            ->selectRaw('SUM(CASE WHEN activo = 1 THEN 1 ELSE 0 END) as activas')
            ->selectRaw('SUM(CASE WHEN activo = 0 THEN 1 ELSE 0 END) as inactivas')
            ->first();

        return view('livewire.administracion.plantillas', [
            'estadisticas' => $estadisticas
        ]);
    }
}
