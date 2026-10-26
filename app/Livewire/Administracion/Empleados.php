<?php

namespace App\Livewire\Administracion;

use App\Models\Empleado;
use App\Models\Puesto;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Empleados extends Component
{
    public string $buscar = '';

    public bool $mostrarModal = false;

    public ?int $empleadoId = null;

    public ?int $usuarioId = null;

    public string $nombre = '';

    public string $correo = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?int $puestoId = null;

    public ?int $jefeId = null;

    public bool $activo = true;

    public bool $esAdmin = false;

    /**
     * Abre el formulario vacío para registrar un empleado.
     */
    public function crear(): void
    {
        $this->limpiarFormulario();

        $this->mostrarModal = true;
    }

    /**
     * Carga la información de un empleado existente.
     */
    public function editar(int $empleadoId): void
    {
        $empleado = Empleado::query()
            ->with('usuario')
            ->findOrFail($empleadoId);

        $this->empleadoId = $empleado->id;
        $this->usuarioId = $empleado->user_id;
        $this->nombre = $empleado->usuario->name;
        $this->correo = $empleado->usuario->email;
        $this->puestoId = $empleado->puesto_id;
        $this->jefeId = $empleado->jefe_id;
        $this->activo = (bool) $empleado->activo;
        $this->esAdmin = (bool) $empleado->usuario->es_admin;

        /*
         * Al editar, la contraseña se deja vacía.
         * Solo se modifica si el administrador escribe una nueva.
         */
        $this->password = '';
        $this->password_confirmation = '';

        $this->mostrarModal = true;
    }

    /**
     * Guarda un empleado nuevo o actualiza uno existente.
     */
    public function guardar(): void
    {
        $reglasPassword = $this->empleadoId
            ? ['nullable', 'string', 'min:8', 'confirmed']
            : ['required', 'string', 'min:8', 'confirmed'];

        $datos = $this->validate([
            'nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'correo' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->usuarioId),
            ],
            'password' => $reglasPassword,
            'puestoId' => [
                'required',
                'exists:puestos,id',
            ],
            'jefeId' => [
                'nullable',
                'exists:empleados,id',
                Rule::notIn([$this->empleadoId]),
            ],
            'activo' => [
                'boolean',
            ],
            'esAdmin' => [
                'boolean',
            ],

        ], [
            'nombre.required' => 'El nombre del empleado es obligatorio.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Ingrese un correo electrónico válido.',
            'correo.unique' => 'Ya existe un usuario con este correo electrónico.',
            'password.required' => 'La contraseña inicial es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
            'puestoId.required' => 'Seleccione un puesto.',
            'puestoId.exists' => 'El puesto seleccionado no es válido.',
            'jefeId.exists' => 'El jefe inmediato seleccionado no es válido.',
            'jefeId.not_in' => 'Un empleado no puede ser su propio jefe inmediato.',
        ]);

        $esEdicion = $this->empleadoId !== null;

        if ($this->usuarioId === Auth::id() && ! $datos['esAdmin']) {
            $this->addError(
                'esAdmin',
                'No puede retirar su propio permiso administrativo.'
            );

            return;
        }

        DB::transaction(function () use ($datos) {
            /*
             * Crea o actualiza la cuenta utilizada para iniciar sesión.
             */
            $usuario = $this->usuarioId
                ? User::findOrFail($this->usuarioId)
                : new User();

            $usuario->name = trim($datos['nombre']);
            $usuario->email = mb_strtolower(trim($datos['correo']));
            $usuario->es_admin = $datos['esAdmin'];

            /*
             * Al editar, la contraseña únicamente cambia
             * cuando se escribe una nueva.
             */
            if ($this->password !== '') {
                $usuario->password = $datos['password'];
            }

            $usuario->save();

            /*
             * Crea o actualiza los datos organizacionales.
             */
            Empleado::updateOrCreate(
                [
                    'id' => $this->empleadoId,
                ],
                [
                    'user_id' => $usuario->id,
                    'puesto_id' => $datos['puestoId'],
                    'jefe_id' => $datos['jefeId'] ?: null,
                    'activo' => $datos['activo'],
                ]
            );
        });

        $this->cerrarModal();

        session()->flash(
            'mensaje',
            $esEdicion
                ? 'El empleado fue actualizado correctamente.'
                : 'El empleado fue creado correctamente.'
        );
    }

    /**
     * Activa o desactiva un empleado sin eliminarlo.
     */
    public function cambiarEstado(int $empleadoId): void
    {
        $empleado = Empleado::findOrFail($empleadoId);

        $empleado->update([
            'activo' => ! $empleado->activo,
        ]);

        session()->flash(
            'mensaje',
            $empleado->activo
                ? 'El empleado fue activado correctamente.'
                : 'El empleado fue desactivado correctamente.'
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
     * Limpia los campos y errores del formulario.
     */
    private function limpiarFormulario(): void
    {
        $this->reset(
            'empleadoId',
            'usuarioId',
            'nombre',
            'correo',
            'password',
            'password_confirmation',
            'puestoId',
            'jefeId',
            'activo',
            'esAdmin',
        );

        $this->activo = true;
        $this->esAdmin = false;

        $this->resetValidation();
    }

    /**
     * Carga empleados, puestos y posibles jefes inmediatos.
     */
    public function render()
    {
        $empleados = Empleado::query()
            ->with([
                'usuario',
                'puesto.plantilla',
                'jefe.usuario',
                'jefe.puesto',
            ])
            ->when(
                $this->buscar,
                function ($consulta) {
                    $consulta->where(function ($subconsulta) {
                        $subconsulta
                            ->whereHas('usuario', function ($usuarios) {
                                $usuarios
                                    ->where('name', 'like', '%' . $this->buscar . '%')
                                    ->orWhere('email', 'like', '%' . $this->buscar . '%');
                            })
                            ->orWhereHas('puesto', function ($puestos) {
                                $puestos
                                    ->where('nombre', 'like', '%' . $this->buscar . '%')
                                    ->orWhere('codigo', 'like', '%' . $this->buscar . '%');
                            });
                    });
                }
            )
            ->get()
            ->sortBy(fn (Empleado $empleado) => $empleado->usuario->name)
            ->values();

        $puestos = Puesto::query()
            ->where('activo', true)
            ->with('plantilla')
            ->orderBy('nombre')
            ->get();

        /*
         * Un empleado puede seleccionar como jefe inmediato
         * a cualquier empleado activo, excepto a sí mismo.
         */
        $jefes = Empleado::query()
            ->with([
                'usuario',
                'puesto',
            ])
            ->where('activo', true)
            ->when(
                $this->empleadoId,
                fn ($consulta) => $consulta->where('id', '!=', $this->empleadoId)
            )
            ->get()
            ->sortBy(fn (Empleado $empleado) => $empleado->usuario->name)
            ->values();

        return view('livewire.administracion.empleados', [
            'empleados' => $empleados,
            'puestos' => $puestos,
            'jefes' => $jefes,
        ]);
    }
}