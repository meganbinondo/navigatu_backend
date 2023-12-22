<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Check if the user is either an admin or a customer
        if ($user && ($user->role === 'admin' || $user->role === 'customer')) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }

}