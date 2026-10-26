<?php

namespace App\Livewire\Evaluaciones;

use App\Models\Evaluacion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MisResultados extends Component
{
    /**
     * Muestra los resultados del usuario conectado.
     */
    public function render()
    {
        $usuario = Auth::user();
        $empleado = $usuario?->empleado;

        /*
         * Evita errores si existe una cuenta de usuario
         * que todavía no tiene empleado asociado.
         */
        if (! $empleado) {
            return view('livewire.evaluaciones.mis-resultados', [
                'usuario' => $usuario,
                'empleado' => null,
                'resultadoRecibido' => null,
                'evaluacionesRecibidas' => collect(),
                'resultadosEquipo' => collect(),
            ]);
        }

        /*
         * Evaluaciones que otras personas finalizaron
         * sobre el usuario conectado.
         */
        $evaluacionesRecibidas = Evaluacion::query()
            ->with([
                'evaluador.usuario',
                'evaluador.puesto',
                'evaluado.usuario',
                'evaluado.puesto',
                'plantilla',
                'respuestas.pregunta.dimension',
            ])
            ->where('empleado_evaluado_id', $empleado->id)
            ->where('estado', 'finalizada')
            ->orderBy('fecha_finalizacion')
            ->get();

        /*
         * Resultado consolidado recibido por el usuario.
         * Si varias personas lo evaluaron, se combinan
         * todas las respuestas por dimensión.
         */
        $resultadoRecibido = $this->consolidarEvaluaciones(
            $evaluacionesRecibidas
        );

        /*
         * Evaluaciones que el usuario conectado realizó
         * sobre sus subordinados directos.
         *
         * No se incluyen aquí evaluaciones realizadas
         * hacia su jefe inmediato.
         */
        $evaluacionesEquipo = Evaluacion::query()
            ->with([
                'evaluador.usuario',
                'evaluado.usuario',
                'evaluado.puesto',
                'plantilla',
                'respuestas.pregunta.dimension',
            ])
            ->where('empleado_evaluador_id', $empleado->id)
            ->where('estado', 'finalizada')
            ->whereHas('evaluado', function ($consulta) use ($empleado) {
                $consulta->where('jefe_id', $empleado->id);
            })
            ->orderBy('fecha_finalizacion')
            ->get();

        /*
         * Calcula el resultado individual de cada subordinado
         * evaluado por el usuario conectado.
         */
        $resultadosEquipo = $evaluacionesEquipo
            ->map(function (Evaluacion $evaluacion) {
                return [
                    'evaluacion' => $evaluacion,
                    'resultado' => $this->calcularResultadoEvaluacion(
                        $evaluacion
                    ),
                ];
            });

        /*
         * También calculamos el resultado individual de
         * cada evaluación recibida para mostrar quién evaluó
         * al usuario y qué promedio registró.
         */
        $evaluacionesRecibidas = $evaluacionesRecibidas
            ->map(function (Evaluacion $evaluacion) {
                return [
                    'evaluacion' => $evaluacion,
                    'resultado' => $this->calcularResultadoEvaluacion(
                        $evaluacion
                    ),
                ];
            });

        return view('livewire.evaluaciones.mis-resultados', [
            'usuario' => $usuario,
            'empleado' => $empleado,
            'resultadoRecibido' => $resultadoRecibido,
            'evaluacionesRecibidas' => $evaluacionesRecibidas,
            'resultadosEquipo' => $resultadosEquipo,
        ]);
    }

    /**
     * Calcula el resultado de una evaluación individual.
     *
     * Por cada dimensión obtiene:
     * - suma de calificaciones
     * - cantidad de preguntas respondidas
     * - promedio de la dimensión
     *
     * El promedio general es la suma de los promedios
     * de las dimensiones dividida entre la cantidad
     * de dimensiones.
     */
    private function calcularResultadoEvaluacion(
        Evaluacion $evaluacion
    ): array {
        $dimensiones = $evaluacion
            ->respuestas
            ->groupBy(fn ($respuesta) => $respuesta->pregunta->dimension_id)
            ->map(function (Collection $respuestas) {
                $dimension = $respuestas
                    ->first()
                    ->pregunta
                    ->dimension;

                $suma = $respuestas->sum('calificacion');
                $cantidadPreguntas = $respuestas->count();

                $promedio = $cantidadPreguntas > 0
                    ? $suma / $cantidadPreguntas
                    : 0;

                return [
                    'id' => $dimension->id,
                    'orden' => $dimension->orden,
                    'nombre' => $dimension->nombre,
                    'factor' => $dimension->factor,
                    'suma' => $suma,
                    'cantidad_preguntas' => $cantidadPreguntas,
                    'promedio' => round($promedio, 2),
                ];
            })
            ->sortBy('orden')
            ->values();

        $promedioGeneral = $dimensiones->isNotEmpty()
            ? $dimensiones->avg('promedio')
            : 0;

        return [
            'dimensiones' => $dimensiones,
            'promedio_general' => round($promedioGeneral, 2),
            'estado' => $this->determinarEstado($promedioGeneral),
        ];
    }

    /**
     * Consolida varias evaluaciones recibidas.
     *
     * Ejemplo:
     * si un jefe y tres subordinados evaluaron a una persona,
     * se combinan todas sus respuestas por dimensión.
     */
    private function consolidarEvaluaciones(
        Collection $evaluaciones
    ): ?array {
        if ($evaluaciones->isEmpty()) {
            return null;
        }

        $respuestas = $evaluaciones
            ->flatMap(fn (Evaluacion $evaluacion) => $evaluacion->respuestas);

        $dimensiones = $respuestas
            ->groupBy(fn ($respuesta) => $respuesta->pregunta->dimension_id)
            ->map(function (Collection $respuestasDimension) {
                $dimension = $respuestasDimension
                    ->first()
                    ->pregunta
                    ->dimension;

                $suma = $respuestasDimension->sum('calificacion');
                $cantidadRespuestas = $respuestasDimension->count();

                $promedio = $cantidadRespuestas > 0
                    ? $suma / $cantidadRespuestas
                    : 0;

                return [
                    'id' => $dimension->id,
                    'orden' => $dimension->orden,
                    'nombre' => $dimension->nombre,
                    'factor' => $dimension->factor,
                    'suma' => $suma,
                    'cantidad_respuestas' => $cantidadRespuestas,
                    'promedio' => round($promedio, 2),
                ];
            })
            ->sortBy('orden')
            ->values();

        $promedioGeneral = $dimensiones->isNotEmpty()
            ? $dimensiones->avg('promedio')
            : 0;

        return [
            'cantidad_evaluaciones' => $evaluaciones->count(),
            'dimensiones' => $dimensiones,
            'promedio_general' => round($promedioGeneral, 2),
            'estado' => $this->determinarEstado($promedioGeneral),
        ];
    }

    /**
     * Convierte un promedio de 1 a 4
     * en un estado descriptivo.
     */
    private function determinarEstado(float $promedio): array
    {
        return match (true) {
            $promedio >= 3.50 => [
                'nombre' => 'Desempeño sobresaliente',
                'descripcion' => 'Supera lo esperado',
                'estilo' => 'emerald',
            ],
            $promedio >= 2.50 => [
                'nombre' => 'Cumple lo esperado',
                'descripcion' => 'Desempeño satisfactorio',
                'estilo' => 'blue',
            ],
            $promedio >= 1.50 => [
                'nombre' => 'Necesita mejora',
                'descripcion' => 'Requiere seguimiento',
                'estilo' => 'amber',
            ],
            default => [
                'nombre' => 'Desempeño deficiente',
                'descripcion' => 'Requiere atención prioritaria',
                'estilo' => 'red',
            ],
        };
    }
}