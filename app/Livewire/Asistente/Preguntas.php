<?php

namespace App\Livewire\Asistente;

use App\Models\Factor;
use App\Models\Pregunta;
use App\Models\Tema;
use Livewire\Component;
use Livewire\WithPagination;

class Preguntas extends Component
{
    use WithPagination;

    public string $buscar = '';
    public string $filtroNps = 'todos';

    public bool $mostrarModal = false;

    public ?int $preguntaId = null;
    public ?int $factorId = null;
    public ?int $temaId = null;

    public string $tipo = 'texto';
    public $opciones = '';
    public bool $es_nps = false;
    public string $texto = '';
    public bool $activo = false;


    public function crear(): void
    {
        $this->limpiarFormulario();

        $this->mostrarModal = true;
    }


    public function editar(int $preguntaId): void
    {
        $pregunta = Pregunta::findOrFail($preguntaId);

        $this->preguntaId = $pregunta->id;
        $this->factorId = $pregunta->factor_id;
        $this->temaId = $pregunta->tema_id;
        $this->tipo = $pregunta->tipo;

        $this->opciones = is_array($pregunta->opciones)
            ? implode(', ', $pregunta->opciones)
            : $pregunta->opciones;

        $this->es_nps = (bool) $pregunta->es_nps;
        $this->texto = $pregunta->texto;
        $this->activo = (bool) $pregunta->activo;

        $this->mostrarModal = true;
    }


    public function guardar(): void
    {
        $datos = $this->validate([
            'factorId' => [
                'required',
                'exists:factores,id',
            ],

            'temaId' => [
                'nullable',
                'exists:temas,id',
            ],

            'tipo' => [
                'required',
                'string',
                'in:texto,si_no,escala,seleccion_multiple,nps',
            ],

            'opciones' => [
                'nullable',
                'string',
            ],

            'es_nps' => [
                'boolean',
            ],

            'texto' => [
                'required',
                'string',
            ],
        ]);


        $esEdicion = $this->preguntaId !== null;


        $opcionesArray = !empty($datos['opciones'])
            ? array_map(
                'trim',
                explode(',', $datos['opciones'])
            )
            : null;


        $datosPregunta = [
            'factor_id' => $datos['factorId'],
            'tema_id' => $datos['temaId'] ?? null,
            'tipo' => $datos['tipo'],
            'opciones' => $opcionesArray,
            'es_nps' => $datos['es_nps'],
            'texto' => trim($datos['texto']),
        ];


        if ($esEdicion) {

            $pregunta = Pregunta::findOrFail(
                $this->preguntaId
            );

            $pregunta->update($datosPregunta);

        } else {

            // Toda pregunta nueva inicia inactiva.
            $datosPregunta['activo'] = false;

            Pregunta::create($datosPregunta);
        }


        $this->cerrarModal();


        session()->flash(
            'mensaje',
            $esEdicion
                ? 'La pregunta fue actualizada correctamente.'
                : 'La pregunta fue creada correctamente.'
        );
    }


    public function cerrarModal(): void
    {
        $this->mostrarModal = false;

        $this->limpiarFormulario();
    }


    private function limpiarFormulario(): void
    {
        $this->reset([
            'preguntaId',
            'factorId',
            'temaId',
            'opciones',
            'texto',
            'es_nps',
        ]);

        $this->tipo = 'texto';
        $this->activo = false;

        $this->resetValidation();
    }
    public function updatedBuscar(): void
    {
        $this->resetPage();
    }
    public function updatedFiltroNps(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.asistente.preguntas', [

            'preguntas' => Pregunta::query()

                ->with([
                    'factor',
                    'tema',
                ])

                ->when(
                    $this->buscar,
                    fn ($query) => $query->where(
                        'texto',
                        'like',
                        '%' . $this->buscar . '%'
                    )
                )

                ->when(
                    $this->filtroNps === 'nps',
                    fn ($query) => $query->where(
                        'es_nps',
                        true
                    )
                )

                ->when(
                    $this->filtroNps === 'no_nps',
                    fn ($query) => $query->where(
                        'es_nps',
                        false
                    )
                )

                ->latest('id')

                ->paginate(10),

           // Conviene cuando la consulta es sencilla y solo necesitas enviarla a la vista en ese lugar.
            'factores' => Factor::query()
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(),


            'temas' => Tema::query()
                ->where('activo', true)
                ->orderBy('nombre')
                ->get(),
        ]);
    }
}