<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectUnauthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            $this->checkCampaign($request);

            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->route('client.auth.login', ['lang' => locale()]);
        }

        return $next($request);
    }

    protected function checkCampaign($request): void
    {
        if ($request->has('campaign')) {
            session()->put('campaign', $request->get('campaign'));
        }
    }
}
