<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Laisse passer uniquement les utilisateurs ayant l'un des rôles demandés.
 * Exemple d'usage sur une route : ->middleware('role:admin,super_admin')
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Le rôle de l'utilisateur ne fait pas partie des rôles autorisés.
        if (! $user || ! in_array($user->role->value, $roles, true)) {
            abort(403, 'Accès réservé.');
        }

        return $next($request);
    }
}
