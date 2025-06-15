<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!$request->user() || !$request->user()->hasRole($role)) {
            // Redirige a la página de inicio si el usuario no tiene el rol necesario
            return redirect('/');
        }

        return $next($request);
    }
}

