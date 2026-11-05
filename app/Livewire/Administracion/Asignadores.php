<?php

namespace App\Livewire\Administracion;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;

class Asignadores extends Component
{
    use WithPagination;
    #[Url]
    public string $buscar = '';
    public string $nombre = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    // x-data-table
    public array $filters = [];
    public string $sortBy = 'name';
    public string $sortDirection = 'asc';

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
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
            'nombre.required' => 'Ingrese el nombre del asignador.',
            'email.required' => 'Ingrese el correo electrónico.',
            'email.email' => 'Ingrese un correo válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'Ingrese una contraseña.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }

    public function crear(): void
    {
        $this->resetData();
        Flux::modal('nuevo-asignador')->show();
    }
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
    }
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
    public function cerrarModal(): void
    {
        $this->resetData();

        Flux::modal('nuevo-asignador')->close();
    }
    public function render()
    {
        $headers = [
            ['index' => 'name', 'label' => 'Asignador'],
            ['index' => 'rol', 'label' => 'Rol'],
            ['index' => 'plantillas_count', 'label' => 'Plantillas asignadas'],
            ['index' => 'actions', 'label' => 'Acciones'],
        ];

        $consulta = User::query()
        ->where('rol', 'asignador')
        ->withCount('plantillas');

        if (trim($this->buscar) !== '') {
            $buscar = trim($this->buscar);

            $consulta->where(function ($query) use ($buscar) {
                $query->where('name', 'like', "%{$buscar}%")
                    ->orWhere('email', 'like', "%{$buscar}%");
            });
        }
        $rows = $consulta
        ->orderBy('name')
        ->paginate(10);

       return view('livewire.administracion.asignadores', [
            'totalAsignadores' => User::where('rol', 'asignador')->count(),
             ...compact('headers', 'rows'),
        ]);
    }
}
