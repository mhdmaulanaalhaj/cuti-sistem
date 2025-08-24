<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HrMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'HR') {
            return $next($request);
        }

        // kalau bukan hr, balikin ke dashboard
        return redirect('/dashboard')->with('error', 'Akses hanya untuk HR.');
    }
}
