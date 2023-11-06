<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string[]  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Verifica si el usuario tiene el rol necesario
        if (in_array(auth()->user()->rol->rol_name, $roles)) {
            return $next($request);
        }

        return abort(403, 'No tienes permiso para acceder a esta página.');
    }
}
