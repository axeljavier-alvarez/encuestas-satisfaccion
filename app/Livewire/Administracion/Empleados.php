<?php

namespace App\Livewire\Administracion;

// use App\Models\{Empleado, Puesto, User};
// use Illuminate\Support\Facades\{DB, Hash};
// use Illuminate\Validation\Rule;
// use Illuminate\Validation\ValidationException;
// use Livewire\Attributes\Url;
use Livewire\Component;
// use Livewire\WithPagination;
// use Flux\Flux;


class Empleados extends Component
{
    // use WithPagination;
    // #[Url]
    // public string $buscar = '';
    // public string $filtroEstado = 'todos';
    // public string $filtroAcceso = 'todos';
    // public int $porPagina = 10;
    // // empleados
    // public bool $mostrarModal = false;
    // public ?int $empleadoId = null;
    // public string $nombre = '';
    // public string $email = '';
    // public string $password = '';
    // public string $password_confirmation = '';
    // public ?int $puestoId = null;
    // public bool $esAdmin = false;
    // public bool $activo = true;
    // // puestos
    // public bool $mostrarModalPuestos = false;
    // public ?int $puestoEditarId = null;
    // public string $puestoNombre = '';
    // public string $puestoCodigo = '';
    // public bool $puestoActivo = true;

    // public function crear(): void
    // {
    //     $this->limpiarEmpleado();
    //     $this->mostrarModal = true;
    // }

    // public function editar(int $id): void
    // {
    //     $empleado = Empleado::with('usuario')->findOrFail($id);
    //     $this->limpiarEmpleado();
    //     $this->empleadoId = $empleado->id;
    //     $this->nombre = $empleado->usuario->name;
    //     $this->email = $empleado->usuario->email;
    //     $this->puestoId = $empleado->puesto_id;
    //     $this->esAdmin = (bool) $empleado->usuario->es_admin;
    //     $this->activo = (bool) $empleado->activo;
    //     $this->mostrarModal = true;
    // }

    // public function guardar(): void
    // {
    //     $empleado = $this->empleadoId ? Empleado::with('usuario')->findOrFail($this->empleadoId) : null;
    //     // Al editar, ignoramos el correo del mismo usuario en la regla unique.
    //     $usuarioId = $empleado?->user_id;
    //     // Solo continuamos si los datos cumplen las reglas
    //     $datos = $this->validate([
    //         'nombre' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuarioId)],
    //         'password' => [$empleado ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
    //         'puestoId' => ['required', 'integer', Rule::exists('puestos', 'id')->where('activo', true)],
    //         'esAdmin' => ['boolean'],
    //         'activo' => ['boolean'],
    //     ], [
    //         'nombre.required' => 'Ingrese el nombre completo.',
    //         'email.required' => 'Ingrese el correo electrónico.',
    //         'email.unique' => 'El correo ya está registrado.',
    //         'password.required' => 'Ingrese una contraseña.',
    //         'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
    //         'password.confirmed' => 'Las contraseñas no coinciden.',
    //         'puestoId.required' => 'Seleccione un puesto.',
    //         'puestoId.exists' => 'Seleccione un puesto activo.',
    //     ]);
    //     if ($usuarioId === auth()->id() && (!$this->esAdmin || !$this->activo)) {
    //         throw ValidationException::withMessages([
    //             'esAdmin' => 'No puede quitarse permisos administrativos ni desactivar su propia cuenta.',
    //         ]);
    //     }
    //     $esEdicion = $empleado !== null;
    //     // si falla una de las dos tablas se revierte todo
    //     DB::transaction(function () use ($empleado, $datos) {
    //         if ($empleado) {
    //             $usuario = $empleado->usuario;
    //             $usuario->name = trim($datos['nombre']);
    //             $usuario->email = trim($datos['email']);
    //             $usuario->es_admin = $datos['esAdmin'];
    //             // Contraseña opcional al editar: solo cambia si se escribió una nueva.
    //             if (filled($datos['password'])) {
    //                 $usuario->password = Hash::make($datos['password']);
    //             }
    //             $usuario->save();
    //             $empleado->update([
    //                 'puesto_id' => $datos['puestoId'],
    //                 'activo' => $datos['activo']
    //             ]);
    //         } else {
    //             $usuario = User::create([
    //                 'name' => trim($datos['nombre']),
    //                 'email' => trim($datos['email']),
    //                 'password' => Hash::make($datos['password']),
    //                 'es_admin' => $datos['esAdmin'],
    //             ]);

    //             Empleado::create([
    //                 'user_id' => $usuario->id,
    //                 'puesto_id' => $datos['puestoId'],
    //                 'activo' => $datos['activo'],
    //             ]);
    //         }
    //     });
    //     $this->cerrarModal();
    //     session()->flash('mensaje', $esEdicion ? 'Empleado actualizado correctamente.' : 'Empleado creado correctamente.');
    // }
    // /* activar desactivar estado del empleado */
    // public function cambiarEstadoEmpleado(int $empleadoId): void
    // {
    //     DB::transaction(function () use ($empleadoId) {
    //         $empleado = Empleado::findOrFail($empleadoId);
    //         // evitar que el administrador desactive su propia cuenta
    //         if ($empleado->user_id === auth()->id() && $empleado->activo) {
    //             throw ValidationException::withMessages([
    //                 'estadoEmpleado' => 'No puede desactivar su propia cuenta.',
    //             ]);
    //         }
    //         // para reactivar un empleado su puesto debe estar activo
    //         if (
    //             !$empleado->activo && !$empleado->puesto()->where('activo', true)->exists()
    //         ) {
    //             throw ValidationException::withMessages([
    //                 'estadoEmpleado' => 'Active primero el puesto del empleado.'
    //             ]);
    //         }
    //         // invertir el estado actual
    //         $empleado->activo = !$empleado->activo;
    //         $empleado->save();
    //     });
    //     session()->flash(
    //         'mensaje',
    //         'Estado del empleado actualizado correctamente.'
    //     );
    // }
    // /* ocultar formulario y limpiar campos */
    // public function cerrarModal(): void
    // {
    //     $this->mostrarModal = false;
    //     $this->limpiarEmpleado();
    // }
    // /* limpiar empleado */
    // private function limpiarEmpleado(): void
    // {
    //     $this->reset(['empleadoId', 'nombre', 'email', 'password', 'password_confirmation', 'puestoId', 'esAdmin', 'activo']);

    //     $this->activo = true;

    //     $this->resetValidation();
    // }
    // /* preparar y abrir modal para puestos */
    // public function gestionarPuestos(): void
    // {
    //     $this->limpiarPuesto();
    //     $this->mostrarModalPuestos = true;
    // }

    // public function crearPuesto(): void
    // {
    //     $this->limpiarPuesto();
    // }

    // public function editarPuesto(int $id): void
    // {
    //     $puesto = Puesto::findOrFail($id);
    //     $this->limpiarPuesto();
    //     $this->puestoEditarId = $puesto->id;
    //     $this->puestoNombre = $puesto->nombre;
    //     $this->puestoCodigo = $puesto->codigo;
    //     $this->puestoActivo = (bool) $puesto->activo;
    // }

    // public function guardarPuesto(): void
    // {
    //     $datos = $this->validate([
    //         'puestoNombre' => ['required', 'string', 'max:150'],
    //         'puestoCodigo' => ['required', 'string', 'max:20', Rule::unique('puestos', 'codigo')->ignore($this->puestoEditarId)],
    //         'puestoActivo' => ['boolean'],
    //     ], [
    //         'puestoNombre.required' => 'Ingrese el nombre del puesto.',
    //         'puestoCodigo.required' => 'Ingrese el código del puesto.',
    //         'puestoCodigo.unique' => 'El código ya está registrado.',
    //     ]);

    //     if (
    //         $this->puestoEditarId && !$this->puestoActivo &&

    //         Puesto::whereKey($this->puestoEditarId)->whereHas('empleados', fn($q) => $q->where('activo', true))->exists()
    //     ) {

    //         throw ValidationException::withMessages(['puestoActivo' => 'No puede desactivar un puesto con empleados activos.']);
    //     }

    //     // Con ID actualiza; sin ID crea un nuevo registro.
    //     Puesto::updateOrCreate(['id' => $this->puestoEditarId], [

    //         'nombre' => trim($datos['puestoNombre']),

    //         'codigo' => trim($datos['puestoCodigo']),

    //         'activo' => $datos['puestoActivo'],

    //     ]);

    //     $this->limpiarPuesto();

    //     session()->flash('mensaje', 'Puesto guardado correctamente.');
    // }


    // /**
    //  * Activa o desactiva un puesto.
    //  *
    //  * No permite desactivar puestos que tengan empleados activos.
    //  */
    // public function cambiarEstadoPuesto(int $puestoId): void
    // {
    //     DB::transaction(function () use ($puestoId) {

    //         $puesto = Puesto::findOrFail($puestoId);

    //         // Impide desactivar un puesto con empleados activos.
    //         if (
    //             $puesto->activo &&
    //             $puesto->empleados()->where('activo', true)->exists()
    //         ) {
    //             throw ValidationException::withMessages([
    //                 'estadoPuesto' =>
    //                 'No puede desactivar un puesto con empleados activos.',
    //             ]);
    //         }

    //         // Invierte el estado.
    //         $puesto->activo = !$puesto->activo;
    //         $puesto->save();
    //     });

    //     session()->flash(
    //         'mensaje',
    //         'Estado del puesto actualizado correctamente.'
    //     );
    // }


    // /**
    //  * Cierra la gestión de puestos y limpia sus campos.
    //  */
    // public function cerrarModalPuestos(): void

    // {

    //     $this->mostrarModalPuestos = false;

    //     $this->limpiarPuesto();
    // }

    // /**
    //  * Restablece los campos de puesto y los errores de validación.
    //  */
    // private function limpiarPuesto(): void

    // {

    //     $this->reset(['puestoEditarId', 'puestoNombre', 'puestoCodigo', 'puestoActivo']);

    //     $this->puestoActivo = true;

    //     $this->resetValidation();
    // }

    // /**
    //  * Cuando cambia la búsqueda, vuelve a la primera página.
    //  */
    // public function updatedBuscar(): void
    // {
    //     $this->resetPage();
    // }

    // /**
    //  * Cuando cambia el filtro de estado, vuelve a la primera página.
    //  */
    // public function updatedFiltroEstado(): void
    // {
    //     $this->resetPage();
    // }

    // /**
    //  * Cuando cambia el filtro de acceso, vuelve a la primera página.
    //  */
    // public function updatedFiltroAcceso(): void
    // {
    //     $this->resetPage();
    // }

    // /**
    //  * Cuando cambia la cantidad de registros, vuelve a la primera página.
    //  */
    // public function updatedPorPagina(): void
    // {
    //     $this->resetPage();
    // }

    // /**
    //  * Quita los filtros de la tabla y regresa a la primera página.
    //  */
    // public function limpiarFiltros(): void

    // {

    //     $this->buscar = '';

    //     $this->filtroEstado = 'todos';

    //     $this->filtroAcceso = 'todos';

    //     $this->resetPage();
    // }




    public function render()
    {
        // $consulta = Empleado::query()->with(['usuario', 'puesto']);
        // // buscar en users.name, users.email o puestos.nombre
        // if (trim($this->buscar) !== '') {
        //     $buscar = trim($this->buscar);
        //     $consulta->where(function ($q) use ($buscar) {
        //         $q->whereHas('usuario', fn($u) => $u->where('name', 'like', "%{$buscar}%")->orWhere('email', 'like', "%{$buscar}%"))
        //             ->orWhereHas('puesto', fn($p) => $p->where('nombre', 'like', "%{$buscar}%"));
        //     });
        // }
        // if ($this->filtroEstado !== 'todos') {
        //     $consulta->where('activo',  $this->filtroEstado === 'activos');
        // }
        // if ($this->filtroAcceso !== 'todos') {
        //     $consulta->whereHas('usuario', fn($u) => $u->where('es_admin', $this->filtroAcceso === 'administradores'));
        // }
        

        return view('livewire.administracion.empleados'
        // , 
        // [

        //     'empleados' => $consulta->orderByDesc('id')->paginate($this->porPagina),

        //     'puestos' => Puesto::withCount('empleados')->orderBy('nombre')->get(),

        //     'totalActivos' => Empleado::where('activo', true)->count(),

        //     'totalInactivos' => Empleado::where('activo', false)->count(),

        // ]
        );
    }
}
