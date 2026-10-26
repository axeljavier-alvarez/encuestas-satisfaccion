<?php

namespace App\Livewire\Administracion;

use App\Models\Plantilla;
use App\Models\Puesto;
use App\Models\RelacionPuesto;
use Illuminate\Validation\Rule;
use Livewire\Component;

class RelacionesPuestos extends Component
{
    public string $buscar = '';

    public bool $mostrarModal = false;

    public ?int $relacionId = null;

    public ?int $puestoEvaluadorId = null;

    public ?int $puestoEvaluadoId = null;

    public ?int $plantillaId = null;

    public ?string $tipoRelacion = null;

    public bool $activo = true;

    /**
     * Abre el formulario vacío para registrar una relación.
     */
    public function crear(): void
    {
        $this->limpiarFormulario();

        $this->mostrarModal = true;
    }

    /**
     * Carga una relación existente para modificarla.
     */
    public function editar(int $relacionId): void
    {
        $relacion = RelacionPuesto::findOrFail($relacionId);

        $this->relacionId = $relacion->id;
        $this->puestoEvaluadorId = $relacion->puesto_evaluador_id;
        $this->puestoEvaluadoId = $relacion->puesto_evaluado_id;
        $this->plantillaId = $relacion->plantilla_id;
        $this->tipoRelacion = $relacion->tipo_relacion;
        $this->activo = (bool) $relacion->activo;

        $this->resetValidation();

        $this->mostrarModal = true;
    }

    /**
     * Crea o actualiza una relación entre puestos.
     */
    public function guardar(): void
    {
        $datos = $this->validate([
            'puestoEvaluadorId' => [
                'required',
                'exists:puestos,id',
            ],
            'puestoEvaluadoId' => [
                'required',
                'exists:puestos,id',
                Rule::notIn([
                    $this->puestoEvaluadorId,
                ]),
                Rule::unique(
                    'relaciones_puestos',
                    'puesto_evaluado_id'
                )
                    ->where(
                        fn ($consulta) => $consulta->where(
                            'puesto_evaluador_id',
                            $this->puestoEvaluadorId
                        )
                    )
                    ->ignore($this->relacionId),
            ],
            'plantillaId' => [
                'required',
                'exists:plantillas,id',
            ],
            'tipoRelacion' => [
                'required',
                Rule::in([
                    'descendente',
                    'ascendente',
                    'lateral',
                    'otra',
                ]),
            ],
            'activo' => [
                'boolean',
            ],
        ], [
            'puestoEvaluadorId.required' => 'Seleccione el puesto evaluador.',
            'puestoEvaluadorId.exists' => 'El puesto evaluador seleccionado no es válido.',

            'puestoEvaluadoId.required' => 'Seleccione el puesto evaluado.',
            'puestoEvaluadoId.exists' => 'El puesto evaluado seleccionado no es válido.',
            'puestoEvaluadoId.not_in' => 'Un puesto no puede evaluarse a sí mismo.',
            'puestoEvaluadoId.unique' => 'Esta relación entre puestos ya existe.',

            'plantillaId.required' => 'Seleccione la plantilla que usará esta relación.',
            'plantillaId.exists' => 'La plantilla seleccionada no es válida.',

            'tipoRelacion.required' => 'Seleccione el tipo de relación.',
            'tipoRelacion.in' => 'El tipo de relación seleccionado no es válido.',
        ]);

        $esEdicion = $this->relacionId !== null;

        RelacionPuesto::updateOrCreate(
            [
                'id' => $this->relacionId,
            ],
            [
                'puesto_evaluador_id' => $datos['puestoEvaluadorId'],
                'puesto_evaluado_id' => $datos['puestoEvaluadoId'],
                'plantilla_id' => $datos['plantillaId'],
                'tipo_relacion' => $datos['tipoRelacion'],
                'activo' => $datos['activo'],
            ]
        );

        $this->cerrarModal();

        session()->flash(
            'mensaje',
            $esEdicion
                ? 'La relación fue actualizada correctamente.'
                : 'La relación fue creada correctamente.'
        );
    }

    /**
     * Activa o desactiva una relación sin eliminarla.
     */
    public function cambiarEstado(int $relacionId): void
    {
        $relacion = RelacionPuesto::findOrFail($relacionId);

        $relacion->update([
            'activo' => ! $relacion->activo,
        ]);

        session()->flash(
            'mensaje',
            $relacion->activo
                ? 'La relación fue activada correctamente.'
                : 'La relación fue desactivada correctamente.'
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
     * Limpia los campos y mensajes de validación.
     */
    private function limpiarFormulario(): void
    {
        $this->reset(
            'relacionId',
            'puestoEvaluadorId',
            'puestoEvaluadoId',
            'plantillaId',
            'tipoRelacion',
            'activo'
        );

        $this->activo = true;

        $this->resetValidation();
    }

    /**
     * Carga las relaciones existentes, puestos y plantillas disponibles.
     */
    public function render()
    {
        $relaciones = RelacionPuesto::query()
            ->with([
                'puestoEvaluador',
                'puestoEvaluado',
                'plantilla',
            ])
            ->when(
                $this->buscar,
                function ($consulta) {
                    $consulta->where(function ($subconsulta) {
                        $subconsulta
                            ->whereHas(
                                'puestoEvaluador',
                                function ($puestos) {
                                    $puestos
                                        ->where(
                                            'nombre',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        )
                                        ->orWhere(
                                            'codigo',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        );
                                }
                            )
                            ->orWhereHas(
                                'puestoEvaluado',
                                function ($puestos) {
                                    $puestos
                                        ->where(
                                            'nombre',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        )
                                        ->orWhere(
                                            'codigo',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        );
                                }
                            )
                            ->orWhereHas(
                                'plantilla',
                                function ($plantillas) {
                                    $plantillas
                                        ->where(
                                            'nombre',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        )
                                        ->orWhere(
                                            'codigo',
                                            'like',
                                            '%' . $this->buscar . '%'
                                        );
                                }
                            );
                    });
                }
            )
            ->get()
            ->sortBy(
                fn (RelacionPuesto $relacion) =>
                    $relacion->puestoEvaluador->nombre
                    . ' - '
                    . $relacion->puestoEvaluado->nombre
            )
            ->values();

        /*
         * Incluimos también puestos inactivos para que una relación
         * histórica pueda continuar editándose correctamente.
         */
        $puestos = Puesto::query()
            ->orderBy('nombre')
            ->get();

        $plantillas = Plantilla::query()
            ->orderBy('codigo')
            ->orderBy('nombre')
            ->get();

        return view(
            'livewire.administracion.relaciones-puestos',
            [
                'relaciones' => $relaciones,
                'puestos' => $puestos,
                'plantillas' => $plantillas,
                'tiposRelacion' => [
                    'descendente' => 'Descendente',
                    'ascendente' => 'Ascendente',
                    'lateral' => 'Lateral',
                    'otra' => 'Otra',
                ],
            ]
        );
    }
}