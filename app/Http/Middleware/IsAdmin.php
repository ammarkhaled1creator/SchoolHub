<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{

    $user = auth('api')->user();

    
    if (!$user || $user->role->name !== "Admin") {
        return response()->json([
            'message' => 'Access denied. Admin rights required.'
        ], 403); 
    }

    return $next($request); 
}
}
