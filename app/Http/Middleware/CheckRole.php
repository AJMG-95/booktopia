<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Asegúrate de importar el modelo User

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$role)
    {
        $userAuth = Auth::user();
        $user = new User(); // Instancia directamente el modelo User

        // Ejemplo: Verificar si el usuario tiene el rol requerido
        if ($userAuth && $user->hasAnyRole($role)) {
            return $next($request);
        }

        // Redirigir o denegar el acceso según sea necesario
        return abort(403, 'No tienes permisos para acceder a esta página.');
    }
}
