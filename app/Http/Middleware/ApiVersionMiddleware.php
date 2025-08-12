<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiVersionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $version): Response
    {
        $reqVersion = $request->header('X-API-Version', 'v1');

        if ($reqVersion !== $version) {
            return response()->json([
                'success' => 0,
                'message' => 'Invalid API version'
            ], 400);
        }

        return $next($request);
    }
}
