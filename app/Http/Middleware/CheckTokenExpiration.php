<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;

class CheckTokenExpiration
{
    public function handle($request, Closure $next)
    {
        try {
            $user = FacadesJWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            // Token has expired, log out the user
            auth()->logout();
            return response()->json(['message' => 'Token expired. Please log in again.'], 401);
        }

        return $next($request);
    }
}
