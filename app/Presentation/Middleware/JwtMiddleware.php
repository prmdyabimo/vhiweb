<?php

namespace App\Presentation\Middleware;

use App\Helpers\ResponseFormatterHelper;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return ResponseFormatterHelper::error('User not found', 404);
            }

        } catch (JWTException $err) {
            return ResponseFormatterHelper::error('Token invalid', 401, $err->getMessage());
        }

        return $next($request);
    }
}