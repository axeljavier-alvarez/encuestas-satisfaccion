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
            'name',
            'email',
            'rol',
            'activo',
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
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
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

    // Guardar asignador
    public function guardar(): void
    {
        $this->validate();

        User::create([
            'name' => trim($this->nombre),
            'email' => trim($this->email),
            'password' => Hash::make($this->password),
            'rol' => 'asignador',
        ]);

        $this->resetData();
        $this->resetPage();

        Flux::modal('nuevo-asignador')->close();

        session()->flash(
            'mensaje',
            'Asignador registrado correctamente.'
        );

        // Cuando tengas el listener de Toast:
        // $this->toastSuccess('Asignador registrado correctamente.');
    }

    // Limpiar formulario
    public function resetData(): void
    {
        $this->reset([
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
