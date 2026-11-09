<?php

namespace App\Livewire\Administracion;

use App\Models\User;
use App\Traits\DataTable;
use App\Traits\Interact;
use Flux\Flux;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Asignadores extends Component
{
    use DataTable, Interact;

    // Formulario
    public string $nombre = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $mensaje = null;
    public ?int $asignadorId = null;
    public ?int $asignadorEstadoId = null;
    public string $nombreAsignadorEstado = '';
    public bool $nuevoEstadoAsignador = false;
    
    // Configuración de columnas
    protected function tableSortableColumns(): array
    {
        return [
            'id',
            'name',
            'rol',
            'activo',
            'plantillas_count',
        ];
    }

    protected function tableFilterableColumns(): array
    {
        return [
            'id',
            'name',
            'email',
            'rol',
            'activo',
            'plantillas_count'
        ];
    }

    // Validaciones
    protected function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                ->ignore($this->asignadorId),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ];
    }

    protected function messages(): array
    {
        return [
            'nombre.required' =>
                'Ingrese el nombre del asignador.',

            'email.required' =>
                'Ingrese el correo electrónico.',

            'email.email' =>
                'Ingrese un correo válido.',

            'email.unique' =>
                'Este correo ya está registrado.',

            'password.required' =>
                'Ingrese una contraseña.',

            'password.min' =>
                'La contraseña debe tener al menos 8 caracteres.',

            'password.confirmed' =>
                'Las contraseñas no coinciden.',
        ];
    }

    // Abrir modal
    public function crear(): void
    {
        $this->resetData();

        Flux::modal('nuevo-asignador')->show();
    }

    public function editar(int $id): void
    {
        $this->resetData();
        $asignador = User::query()
        ->where('rol', 'asignador')
        ->findOrFail($id);
        $this->asignadorId = $asignador->id;
        $this->nombre = $asignador->name;
        $this->email = $asignador->email;
        // no cargar la password almacenada
        $this->password = '';
        $this->password_confirmation = '';
        Flux::modal('nuevo-asignador')->show();
    }

    // Guardar asignador
    public function guardar(): void
    {
        $this->validate();

        if($this->asignadorId){
            $asignador = User::query()
            ->where('rol', 'asignador')
            ->findOrFail($this->asignadorId);

            $datos = [
                'name' => trim($this->nombre),
                'email' => trim($this->email)
            ];

            // Actualizar contraseña únicamente si ingresó una nueva
            if (filled($this->password)) {
                $datos['password'] = Hash::make($this->password);
            }
            $asignador->update($datos);
            $mensaje = 'Asignador actualizado correctamente.';
        } else {
            $password = filled($this->password)
            ? $this->password
            : 'ClaveDemo2026*';


            User::create([
                'name' => trim($this->nombre),
                'email' => trim($this->email),
                'password' => Hash::make($password),
                'rol' => 'asignador',
            ]);

            $mensaje = 'Asignador registrado correctamente.';
        }

        
        $this->resetData();

        Flux::modal('nuevo-asignador')->close();
           
        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }

    

    // confirmar cambio estado
    public function confirmarCambioEstado(int $id): void
    {
        $asignador = User::query()
        ->where('rol', 'asignador')
        ->findOrFail($id);

        $this->asignadorEstadoId = $asignador->id;
        $this->nombreAsignadorEstado = $asignador->name;
        $this->nuevoEstadoAsignador = !(bool) $asignador->activo;

         Flux::modal('confirmar-estado-asignador')->show();
    }

    // cambiar estado
    public function cambiarEstadoAsignador(): void
    {
        if($this->asignadorEstadoId === null){
            return;
        }

        $asignador = User::query()
        ->where('rol', 'asignador')
        ->findOrFail($this->asignadorEstadoId);

        $nuevoEstado = ! (bool) $asignador->activo;
        $asignador->activo = $nuevoEstado;
        $asignador->save();
        $mensaje = $nuevoEstado
        ? 'Asignador activado correctamente'
        : 'Asignador desactivado correctamente.';

        $this->reset([
           'asignadorEstadoId',
           'nombreAsignadorEstado',
           'nuevoEstadoAsignador' 
        ]);

        Flux::modal('confirmar-estado-asignador')->close();

        $this->dispatch(
            'mostrar-mensaje',
            mensaje: $mensaje,
            tipo: 'success'
        );
    }


    // Limpiar formulario
    public function resetData(): void
    {
        $this->reset([
            'asignadorId',
            'nombre',
            'email',
            'password',
            'password_confirmation',
        ]);

        $this->resetValidation();
    }

    // Cerrar modal
    public function cerrarModal(): void
    {
        $this->resetData();

        Flux::modal('nuevo-asignador')->close();
    }

    // Consulta principal
    public function render()
    {
        $headers = [
            [
                'index' => 'id',
                'label' => '#',
            ],
            [
                'index' => 'name',
                'label' => 'Datos asignador',
            ],
            [
                'index' => 'rol',
                'label' => 'Rol',
            ],
            [
                'index' => 'activo',
                'label' => 'Estado',
            ],
            [
                'index' => 'plantillas_count',
                'label' => 'Plantillas asignadas',
            ],
            [
                'index' => 'actions',
                'label' => 'Acciones',
            ],
        ];

        $consulta = User::query()
            ->where('rol', 'asignador')
            ->withCount('plantillas');

        // Buscar por nombre o correo
        if (trim($this->search) !== '') {
            $buscar = trim($this->search);

            $consulta->where(function ($query) use ($buscar) {
                $query
                    ->where('name', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        // Filtros avanzados
        $this->applyTableFilters($consulta);

        // Ordenamiento
        $this->applyTableSorting($consulta);

        // Paginación
        $rows = $consulta->paginate(
            $this->getPerPage()
        );

        return view(
            'livewire.administracion.asignadores',
            [
                'headers' => $headers,
                'rows' => $rows,
                'totalAsignadores' => User::query()
                    ->where('rol', 'asignador')
                    ->count(),
            ]
        );
    }
}
