<?php

use App\Livewire\Administracion\Empleados;
use App\Livewire\Administracion\Puestos;
use App\Livewire\Administracion\RelacionesPuestos;
use App\Livewire\Administracion\Plantillas;
use App\Livewire\Evaluaciones\MisResultados;
use App\Livewire\Evaluaciones\ResponderEvaluacion;
use App\Livewire\Administracion\SeguimientoEvaluaciones;
use Illuminate\Support\Facades\Route;
// preguntas
use App\Livewire\Administracion\Preguntas;
use App\Livewire\Administracion\TiposRespuesta;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    /*
     * Pantallas disponibles para cualquier empleado autenticado.
     */
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::get(
        'evaluaciones/{evaluacion}/responder',
        ResponderEvaluacion::class
    )->name('evaluaciones.responder');

    Route::get(
        'resultados',
        MisResultados::class
    )->name('evaluaciones.resultados');

    /*
     * Pantallas exclusivas para usuarios administradores.
     */
   
    Route::middleware('admin')
        ->prefix('administracion')
        ->name('administracion.')
        ->group(function () {
            Route::get(
                'puestos',
                Puestos::class
            )->name('puestos');
            Route::get(
                'empleados',
                Empleados::class
            )->name('empleados');
            Route::get(
                'relaciones-puestos',
                RelacionesPuestos::class
            )->name('relaciones-puestos');
            Route::get(
                'seguimiento-evaluaciones',
                SeguimientoEvaluaciones::class
            )->name('seguimiento-evaluaciones');
            Route::get(
                'plantillas',
                Plantillas::class
            )->name('plantillas');
            Route::get(
                'preguntas',
                Preguntas::class
            )->name('preguntas');
       });
});

require __DIR__.'/settings.php';