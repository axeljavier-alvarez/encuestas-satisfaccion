<?php

use App\Livewire\Administracion\Asignadores;
use App\Livewire\Administracion\Plantillas;
use App\Livewire\Administracion\Preguntas;
use App\Livewire\Asignador\PlantillasAsignadas;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ruta inicial según el rol
|--------------------------------------------------------------------------
*/
Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->rol) {
        'admin' => redirect()->route('dashboard'),
        'asignador' => redirect()->route('asignador.plantillas'),
        default => abort(403, 'Rol no autorizado.'),
    };

})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Administrador
    |--------------------------------------------------------------------------
    */
    Route::view('dashboard', 'dashboard')
        ->middleware('admin')
        ->name('dashboard');

    Route::middleware('admin')
        ->prefix('administracion')
        ->name('administracion.')
        ->group(function () {

            Route::get('asignadores', Asignadores::class)
                ->name('asignadores');

            Route::get('plantillas', Plantillas::class)
                ->name('plantillas');

            Route::get('preguntas', Preguntas::class)
                ->name('preguntas');

            Route::get('preguntas/{slug}', Preguntas::class)
                ->name('preguntas.factor');
            
        });

    /*
    |--------------------------------------------------------------------------
    | Asignador
    |--------------------------------------------------------------------------
    */
    Route::middleware('asignador')
        ->prefix('asignador')
        ->name('asignador.')
        ->group(function () {

            Route::get('plantillas', PlantillasAsignadas::class)
                ->name('plantillas');

        });

});

require __DIR__.'/settings.php';
