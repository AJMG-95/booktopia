<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class CheckRole
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $user = Auth::user();

        if ($user->role->name !== $role) {
            throw new AuthorizationException('Acceso no autorizado.');
        }

        return $next($request);
    }
}
