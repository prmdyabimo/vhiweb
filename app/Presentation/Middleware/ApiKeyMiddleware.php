<?php

namespace App\Presentation\Middleware;

use App\Helpers\ResponseFormatterHelper;
use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return ResponseFormatterHelper::error('API key required', 401);
        }

        if ($apiKey !== config('app.api_key')) {
            return ResponseFormatterHelper::error('Invalid API key', 401);
        }

        return $next($request);
    }
}