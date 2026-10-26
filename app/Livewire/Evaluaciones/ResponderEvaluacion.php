<?php

namespace App\Livewire\Evaluaciones;

use App\Models\Evaluacion;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class ResponderEvaluacion extends Component
{
    public Evaluacion $evaluacion;

    public array $respuestas = [];

    public string $observaciones = '';

    /**
     * Se ejecuta cuando se abre el formulario.
     */
    public function mount(Evaluacion $evaluacion): void
    {
        $this->autorizarAcceso($evaluacion);

        $this->cargarEvaluacion($evaluacion);
    }

    /**
     * Comprueba que el usuario autenticado sea realmente
     * la persona asignada para responder esta evaluación.
     */
    private function autorizarAcceso(Evaluacion $evaluacion): void
    {
        $empleado = Auth::user()?->empleado;

        abort_unless($empleado, 403);

        abort_unless(
            $evaluacion->empleado_evaluador_id === $empleado->id,
            403
        );

        abort_if(
            $evaluacion->estado === 'finalizada',
            403,
            'Esta evaluación ya fue finalizada.'
        );
    }

    /**
     * Carga la plantilla, dimensiones, preguntas
     * y respuestas guardadas previamente.
     */
    private function cargarEvaluacion(Evaluacion $evaluacion): void
    {
        $this->evaluacion = $evaluacion->load([
            'evaluador.usuario',
            'evaluador.puesto',
            'evaluado.usuario',
            'evaluado.puesto',
            'plantilla.dimensiones' => fn ($consulta) => $consulta
                ->where('activo', true)
                ->orderBy('orden')
                ->with([
                    'preguntas' => fn ($consulta) => $consulta
                        ->where('activo', true)
                        ->orderBy('orden'),
                ]),
            'respuestas',
        ]);

        $this->observaciones = $this->evaluacion->observaciones ?? '';

        $this->respuestas = $this->evaluacion
            ->respuestas
            ->pluck('calificacion', 'pregunta_id')
            ->map(fn ($calificacion) => (int) $calificacion)
            ->all();
    }

    /**
     * Guarda parcialmente una evaluación.
     * No exige que todas las preguntas estén respondidas.
     */
    public function guardarBorrador(): void
    {
        $this->validarRespuestasRegistradas();

        $this->guardarRespuestas(finalizar: false);

        session()->flash(
            'mensaje',
            'El borrador fue guardado correctamente.'
        );
    }

    /**
     * Finaliza la evaluación.
     * Exige que todas las preguntas tengan calificación.
     */
    public function finalizarEvaluacion()
    {
        $this->validarRespuestasRegistradas();

        $this->validarFormularioCompleto();

        $this->guardarRespuestas(finalizar: true);

        session()->flash(
            'mensaje',
            'La evaluación fue finalizada correctamente.'
        );

        return redirect()->route('dashboard');
    }

    /**
     * Guarda o actualiza cada calificación.
     */
    private function guardarRespuestas(bool $finalizar): void
    {
        DB::transaction(function () use ($finalizar) {
            foreach ($this->respuestas as $preguntaId => $calificacion) {
                Respuesta::updateOrCreate(
                    [
                        'evaluacion_id' => $this->evaluacion->id,
                        'pregunta_id' => $preguntaId,
                    ],
                    [
                        'calificacion' => $calificacion,
                    ]
                );
            }

            $this->evaluacion->update([
                'observaciones' => $this->observaciones ?: null,
                'estado' => $finalizar ? 'finalizada' : 'pendiente',
                'fecha_finalizacion' => $finalizar ? now() : null,
            ]);
        });
    }

    /**
     * Verifica que las respuestas existentes tengan
     * valores válidos entre 1 y 4.
     */
    private function validarRespuestasRegistradas(): void
    {
        $this->validate([
            'respuestas.*' => [
                'integer',
                'between:1,4',
            ],
            'observaciones' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);
    }

    /**
     * Comprueba que se hayan respondido todas las preguntas
     * antes de finalizar la evaluación.
     */
    private function validarFormularioCompleto(): void
    {
        $preguntas = $this->evaluacion
            ->plantilla
            ->dimensiones
            ->flatMap(fn ($dimension) => $dimension->preguntas)
            ->pluck('id');

        $preguntasRespondidas = collect(array_keys($this->respuestas))
            ->map(fn ($preguntaId) => (int) $preguntaId)
            ->intersect($preguntas)
            ->count();

        if ($preguntasRespondidas !== $preguntas->count()) {
            throw ValidationException::withMessages([
                'respuestas' => 'Debe calificar todas las preguntas antes de finalizar la evaluación.',
            ]);
        }
    }

    public function render()
    {
        return view('livewire.evaluaciones.responder-evaluacion');
    }
}