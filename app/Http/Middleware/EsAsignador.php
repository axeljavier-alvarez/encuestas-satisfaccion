<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EsAsignador
{
    /**
     * Permite el acceso únicamente a usuarios asignadores.
     */
    public function handle(Request $request, Closure $next): Response
    {
        abort_unless(
            $request->user()?->rol === 'asignador',
            403,
            'No tiene permiso para acceder a esta sección.'
        );

        return $next($request);
    }
}
