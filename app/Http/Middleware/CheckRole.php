<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Lógica para verificar el rol y permitir o denegar el acceso

        // Ejemplo: Verificar si el usuario tiene el rol requerido
        if ($request->user() && $request->user()->hasRole($role)) {
            return $next($request);
        }

        // Redirigir o denegar el acceso según sea necesario
        return abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
