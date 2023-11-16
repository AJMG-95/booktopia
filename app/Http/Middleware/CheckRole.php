<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\User; // Asegúrate de importar el modelo User

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Obtener el usuario actualmente autenticado
        $user = $request->user();

        // Verificar el rol del usuario
        if ($user && $user->role) {
            if ($user->isAdmin()) {
                return $next($request);
            } elseif ($user->isSubadmin() || $user->isAdmin()) {
                return $next($request);
            }
        }

        // Si el usuario no tiene el rol adecuado, redirigir o denegar el acceso según tu lógica
        abort(403, 'Unauthorized');
    }
}
