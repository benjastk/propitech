<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();

        foreach ($roles as $role) {
            if ($user->roles()->where('nombre', $role)->exists()) {
                return $next($request);
            }
        }

        abort(403, 'No autorizado');
    }
}