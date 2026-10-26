<?php

namespace Database\Seeders;

use App\Models\Empleado;
use App\Models\Evaluacion;
use App\Models\RelacionPuesto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvaluacionesPendientesSeeder extends Seeder
{
    /**
     * Genera evaluaciones pendientes usando la tabla relaciones_puestos.
     *
     * La plantilla ya no se toma del puesto evaluado.
     * Ahora se toma de la relación específica entre puesto evaluador y puesto evaluado.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $relaciones = RelacionPuesto::query()
                ->with([
                    'puestoEvaluador',
                    'puestoEvaluado',
                    'plantilla',
                ])
                ->where('activo', true)
                ->whereNotNull('plantilla_id')
                ->get();

            foreach ($relaciones as $relacion) {
                $empleadosEvaluadores = Empleado::query()
                    ->where('puesto_id', $relacion->puesto_evaluador_id)
                    ->where('activo', true)
                    ->get();

                $empleadosEvaluados = Empleado::query()
                    ->where('puesto_id', $relacion->puesto_evaluado_id)
                    ->where('activo', true)
                    ->get();

                foreach ($empleadosEvaluadores as $evaluador) {
                    foreach ($empleadosEvaluados as $evaluado) {
                        if ($evaluador->id === $evaluado->id) {
                            continue;
                        }

                        $this->crearOActualizarEvaluacion(
                            evaluador: $evaluador,
                            evaluado: $evaluado,
                            plantillaId: $relacion->plantilla_id
                        );
                    }
                }
            }
        });
    }

    /**
     * Crea o actualiza una evaluación pendiente sin dañar historial.
     *
     * Reglas:
     * - Si no existe, se crea como pendiente.
     * - Si existe y está pendiente sin respuestas, se puede corregir la plantilla.
     * - Si existe finalizada o con respuestas, no se toca.
     */
    private function crearOActualizarEvaluacion(
        Empleado $evaluador,
        Empleado $evaluado,
        int $plantillaId
    ): void {
        $evaluacion = Evaluacion::query()
            ->where('empleado_evaluador_id', $evaluador->id)
            ->where('empleado_evaluado_id', $evaluado->id)
            ->first();

        if (! $evaluacion) {
            Evaluacion::create([
                'empleado_evaluador_id' => $evaluador->id,
                'empleado_evaluado_id' => $evaluado->id,
                'plantilla_id' => $plantillaId,
                'estado' => 'pendiente',
                'fecha_finalizacion' => null,
            ]);

            return;
        }

        $tieneRespuestas = DB::table('respuestas')
            ->where('evaluacion_id', $evaluacion->id)
            ->exists();

        if ($evaluacion->estado === 'pendiente' && ! $tieneRespuestas) {
            $evaluacion->update([
                'plantilla_id' => $plantillaId,
                'fecha_finalizacion' => null,
            ]);
        }
    }
}