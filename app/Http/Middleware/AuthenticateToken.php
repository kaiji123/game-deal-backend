<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->bearerToken()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        if (!Auth::guard('sanctum')->check()) {
            return response()->json(['error' => 'Invalid token'], 401);
        }
    
        return $next($request);
    }
    
}
