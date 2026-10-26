<?php

namespace App\Livewire\Administracion;

use App\Models\Plantilla;
use App\Models\Puesto;
use Livewire\Component;

class Puestos extends Component
{
    public string $buscar = '';

    public bool $mostrarModal = false;

    public ?int $puestoId = null;

    public string $codigo = '';

    public string $nombre = '';

    public ?int $plantillaId = null;

    public bool $activo = true;

    /**
     * Muestra el formulario vacío para crear un puesto.
     */
    public function crear(): void
    {
        $this->limpiarFormulario();

        $this->mostrarModal = true;
    }

    /**
     * Carga un puesto existente para modificarlo.
     */
    public function editar(int $puestoId): void
    {
        $puesto = Puesto::findOrFail($puestoId);

        $this->puestoId = $puesto->id;
        $this->codigo = $puesto->codigo;
        $this->nombre = $puesto->nombre;
        $this->plantillaId = $puesto->plantilla_id;
        $this->activo = (bool) $puesto->activo;

        $this->mostrarModal = true;
    }

    /**
     * Guarda un nuevo puesto o actualiza uno existente.
     */
    public function guardar(): void
    {
        $datos = $this->validate([
            'codigo' => [
                'required',
                'string',
                'max:30',
                'unique:puestos,codigo,' . ($this->puestoId ?? 'NULL'),
            ],
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'plantillaId' => [
                'required',
                'exists:plantillas,id',
            ],
            'activo' => [
                'boolean',
            ],
        ], [
            'codigo.required' => 'El código del puesto es obligatorio.',
            'codigo.unique' => 'Ya existe un puesto con este código.',
            'nombre.required' => 'El nombre del puesto es obligatorio.',
            'plantillaId.required' => 'Seleccione una plantilla.',
            'plantillaId.exists' => 'La plantilla seleccionada no es válida.',
        ]);

        $esEdicion = $this->puestoId !== null;

        Puesto::updateOrCreate(
            [
                'id' => $this->puestoId,
            ],
            [
                'codigo' => mb_strtoupper(trim($datos['codigo'])),
                'nombre' => trim($datos['nombre']),
                'plantilla_id' => $datos['plantillaId'],
                'activo' => $datos['activo'],
            ]
        );

        $this->cerrarModal();

        session()->flash(
            'mensaje',
            $esEdicion
                ? 'El puesto fue actualizado correctamente.'
                : 'El puesto fue creado correctamente.'
        );
    }

    /**
     * Cambia el estado del puesto sin eliminarlo.
     */
    public function cambiarEstado(int $puestoId): void
    {
        $puesto = Puesto::findOrFail($puestoId);

        $puesto->update([
            'activo' => ! $puesto->activo,
        ]);

        session()->flash(
            'mensaje',
            $puesto->activo
                ? 'El puesto fue activado correctamente.'
                : 'El puesto fue desactivado correctamente.'
        );
    }

    /**
     * Cierra el formulario modal.
     */
    public function cerrarModal(): void
    {
        $this->mostrarModal = false;

        $this->limpiarFormulario();
    }

    /**
     * Restablece los campos del formulario.
     */
    private function limpiarFormulario(): void
    {
        $this->reset(
            'puestoId',
            'codigo',
            'nombre',
            'plantillaId',
            'activo'
        );

        $this->activo = true;

        $this->resetValidation();
    }

    /**
     * Consulta los puestos y carga las plantillas disponibles.
     */
    public function render()
    {
        $puestos = Puesto::query()
            ->with('plantilla')
            ->when(
                $this->buscar,
                function ($consulta) {
                    $consulta->where(function ($subconsulta) {
                        $subconsulta
                            ->where('codigo', 'like', '%' . $this->buscar . '%')
                            ->orWhere('nombre', 'like', '%' . $this->buscar . '%');
                    });
                }
            )
            ->orderBy('nombre')
            ->get();

        $plantillas = Plantilla::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('livewire.administracion.puestos', [
            'puestos' => $puestos,
            'plantillas' => $plantillas,
        ]);
    }
}