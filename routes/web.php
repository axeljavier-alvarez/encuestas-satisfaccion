<?php

use App\Livewire\Administracion\Empleados;
use App\Livewire\Administracion\Puestos;
use App\Livewire\Administracion\Plantillas;
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