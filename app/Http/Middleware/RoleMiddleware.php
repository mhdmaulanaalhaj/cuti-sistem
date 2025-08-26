<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = Auth::user();

        // Bisa pakai koma atau pipa
        $allowedRoles = preg_split('/[|,]/', $roles);

        // Case insensitive
        $allowedRoles = array_map('strtolower', $allowedRoles);

        if (!$user || !in_array(strtolower($user->role), $allowedRoles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
