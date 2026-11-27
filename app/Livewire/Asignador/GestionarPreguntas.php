<?php

namespace App\Livewire\Asignador;

use App\Models\{Plantilla, Pregunta, Factor};
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class GestionarPreguntas extends Component
{
    private const MAXIMO_PREGUNTAS = 10;

    private const CODIGOS_PREDETERMINADOS = [
        'REC-01',
        'ATR-01',
    ];

    #[Locked]
    public int $plantillaId;
    public string $search = '';
    public ?int $factorSeleccionado = null;
    public array $preguntasSeleccionadas = [];
    public array $tiposRespuestaSeleccionados = [];

    public function mount(int $plantilla): void
    {
        $this->plantillaId = $plantilla;
        $plantilla = $this->obtenerPlantilla();
        $preguntasGuardadas = $plantilla->preguntas()->get();
        $predeterminadas = $this->preguntasPredeterminadas;
        // Incorporar primero las preguntas predeterminadas
        foreach ($predeterminadas as $pregunta) {
            $this->preguntasSeleccionadas[] = $pregunta->id;
            $preguntasGuardada = $preguntasGuardadas
                ->firstWhere('id', $pregunta->id);
            $this->tiposRespuestaSeleccionados[$pregunta->id] =
                $preguntaGuardada?->pivot->tipo_respuesta_id
                ?? $pregunta->tiposRespuesta->first()?->id;
        }
        // Cargar preguntas adicionales guardadas
        foreach ($preguntasGuardadas as $pregunta) {
            if (in_array(
                $pregunta->id,
                $this->preguntasSeleccionadas
            )) {
                continue;
            }
            $this->preguntasSeleccionadas[] = $pregunta->id;
            $this->tiposRespuestaSeleccionados[$pregunta->id] =
                $pregunta->pivot->tipo_respuesta_id;
        }
    }

    /**
     * Verificar que la plantilla pertenezca al asignador.
     */
    private function obtenerPlantilla(): Plantilla
    {
        return Plantilla::query()
            ->whereHas('usuarios', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->findOrFail($this->plantillaId);
    }
    /* información de la plantilla */
    #[Computed]
    public function plantilla(): Plantilla
    {
        return $this->obtenerPlantilla();
    }
    /* obtener preguntas predeterminadas */
    #[Computed]
    public function preguntasPredeterminadas()
    {
        return Pregunta::query()
            ->with(['factor', 'tiposRespuesta'])
            ->whereIn(
                'codigo',
                self::CODIGOS_PREDETERMINADOS
            )
            ->get()
            ->sortBy(function ($pregunta) {
                return array_search(
                    $pregunta->codigo,
                    self::CODIGOS_PREDETERMINADOS
                );
            })
            ->values();
    }
    /* obtener factores con preguntas activas */
    #[Computed]
    public function factores()
    {
        return Factor::query()
            ->whereHas('preguntas', function ($query) {
                $query->where('activo', true);
            })
            ->orderBy('id')
            ->get();
    }
    /* obtener banco de preguntas disponibles */
    #[Computed]
    public function bancoPreguntas()
    {
        return Pregunta::query()
            ->with(['factor', 'tiposRespuesta'])
            ->where('activo', true)
            ->whereNotIn(
                'id',
                $this->preguntasSeleccionadas
            )
            ->whereNotIn(
                'codigo',
                self::CODIGOS_PREDETERMINADOS
            )
            ->when(
                $this->factorSeleccionado,
                function ($query) {
                    $query->where(
                        'factor_id',
                        $this->factorSeleccionado
                    );
                }
            )
            ->when(
                filled($this->search),
                function ($query) {
                    $busqueda = trim($this->search);
                    $query->where(function ($query) use ($busqueda) {
                        $query->where(
                            'texto',
                            'like',
                            "%{$busqueda}%"
                        )->orWhere(
                            'codigo',
                            'like',
                            "%{$busqueda}%"
                        );
                    });
                }
            )
            ->orderBy('factor_id')
            ->orderBy('id')
            ->get();
    }
    /* obtener preguntas seleccionadas en su orden */
    #[Computed]
    public function preguntasFormulario()
    {
        $preguntas = Pregunta::query()
            ->with(['factor', 'tiposRespuesta'])
            ->whereIn('id', $this->preguntasSeleccionadas)
            ->get()
            ->keyBy('id');

        return collect($this->preguntasSeleccionadas)
            ->map(fn($id) => $preguntas->get($id))
            ->filter()
            ->values();
    }
    /* total de preguntas seleccionadas */
    #[Computed]
    public function totalPreguntas(): int
    {
        return count($this->preguntasSeleccionadas);
    }
    /* espacios disponibles */
    #[Computed]
    public function espaciosDisponibles(): int
    {
        return max(
            0,
            self::MAXIMO_PREGUNTAS - $this->totalPreguntas
        );
    }
    /* agregar pregunta al formulario */
    public function agregarPregunta(int $id): void
    {
        $this->obtenerPlantilla();
        if (in_array($id, $this->preguntasSeleccionadas)) {
            return;
        }
        if (
            count($this->preguntasSeleccionadas)
            >= self::MAXIMO_PREGUNTAS
        ) {
            $this->dispatch(
                'mostrar-mensaje',
                mensaje: 'La plantilla admite un máximo de 10 preguntas.',
                tipo: 'error'
            );
            return;
        }

        $pregunta = Pregunta::query()
            ->with('tiposRespuesta')
            ->where('activo', true)
            ->findOrFail($id);

        if ($pregunta->tiposRespuesta->isEmpty()) {
            $this->dispatch(
                'mostrar-mensaje',
                mensaje: 'La pregunta no tiene tipos de respuesta aconfigurados',
                tipo: 'error'
            );
            return;
        }
        $this->preguntasSeleccionadas[] = $pregunta->id;
        $this->tiposRespuestaSeleccionados[$pregunta->id]
            = $pregunta->tiposRespuesta->first()->id;
        $this->actualizarVista();
    }
    /* retirar una pregunta adicional */
    public function quitarPregunta(int $id): void
    {
        $this->obtenerPlantilla();
        if (
            $this->preguntasPredeterminadas
            ->contains('id', $id)
        ) {
            return;
        }
        $this->preguntasSeleccionadas = array_values(
            array_filter(
                $this->preguntasSeleccionadas,
                fn($preguntaId) => (int) $preguntaId !== $id
            )
        );
        unset($this->tiposRespuestaSeleccionados[$id]);
        $this->actualizarVista();
    }
    /* cambiar orden preguntas adicionales */
    public function moverPregunta(int $id, string $direccion): void
    {

    }

    public function render()
    {
        return view('livewire.asignador.gestionar-preguntas');
    }
}
