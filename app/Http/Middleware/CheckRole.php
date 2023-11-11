<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/'); // Redirige si el usuario no está autenticado.
        }

        $user = Auth::user();

        if ($user->role->name !== $role) {
            abort(403, 'Acceso no autorizado.'); // 403 Forbidden si el usuario no tiene el rol requerido.
        }

        return $next($request);
    }
}
