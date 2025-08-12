<?php

namespace App\Http\Middleware;

use App\Models\Merchant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');

        if (!$authHeader || !str_starts_with($authHeader, 'Basic ')) {
            return response()->json([
                'success' => 0,
                'message' => 'Unauthorized'
            ], 401);
        }


        $encodedCredentials = substr($authHeader, 6);
        $decoded = base64_decode($encodedCredentials);
        [$username, $password] = explode(':', $decoded, 2);
        $merchant = Merchant::where('api_username', $username)->where('api_key',$password)->first();

        if (!$merchant) {
            return response()->json([
                'success' => 0,
                'message' => 'Unauthorized'
            ], 401);
        }

        $request->merge(['merchantUser' => $merchant]);


        return $next($request);
    }
}
