<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class HasToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        if(!$token) return ["message" => "Unauthorized", "status" => Response::HTTP_UNAUTHORIZED];

        if(!PersonalAccessToken::findToken($token)) return ["message" => "Unauthorized", "status" => Response::HTTP_UNAUTHORIZED];

        return $next($request);
    }
}
