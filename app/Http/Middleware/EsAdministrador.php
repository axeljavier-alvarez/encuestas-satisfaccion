<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAdministrador
{
    /**
     * Permite continuar únicamente a usuarios administradores.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            $request->user()?->es_admin,
            403,
            'No tiene permiso para acceder a esta sección.'
        );

        return $next($request);
    }
}