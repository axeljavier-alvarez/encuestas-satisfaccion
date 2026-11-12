<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Pregunta;
use App\Livewire\Administracion\Preguntas;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PreguntasPredeterminadasTest extends TestCase
{
    use RefreshDatabase;

    // CREARLO: php artisan make:test PreguntasPredeterminadasTest
    // HACER PRUEBAS  php artisan test --filter=PreguntasPredeterminadasTest

    public function test_no_permite_modificar_obligatoriedad_de_pregunta_predeterminada(): void
    {
        // Crear una pregunta predeterminada para la prueba.
        // Debes contar con factores, temas y tipos de respuesta
        // en la base de datos de pruebas.

        $pregunta = Pregunta::where('es_predeterminada', true)->firstOrFail();

        $obligatoriaOriginal = (bool) $pregunta->obligatoria;

        Livewire::test(Preguntas::class)
            ->set('factorSeleccionado', $pregunta->factor_id)
            ->set('preguntaId', $pregunta->id)
            ->set('temaId', $pregunta->tema_id)
            ->set('texto', $pregunta->texto)
            ->set('obligatoria', $obligatoriaOriginal ? '0' : '1')
            ->set('tiposRespuestaSeleccionados', [])
            ->call('guardar')
            ->assertHasNoErrors();

        $pregunta->refresh();

        $this->assertSame(
            $obligatoriaOriginal,
            (bool) $pregunta->obligatoria
        );
    }


    public function test_no_permite_cambiar_estado_de_pregunta_predeterminada(): void
    {
        $pregunta = Pregunta::where('es_predeterminada', true)->firstOrFail();

        $estadoOriginal = (bool) $pregunta->activo;

        Livewire::test(Preguntas::class)
            ->set('preguntaEstadoId', $pregunta->id)
            ->call('cambiarEstadoPregunta');

        $this->assertSame(
            $estadoOriginal,
            (bool) $pregunta->fresh()->activo
        );
    }
}
