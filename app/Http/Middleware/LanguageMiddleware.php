<?php

namespace App\Http\Middleware;

use Closure;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $segment = $request->segment(1);
        $prevMethod = $request->getMethod();

        if (! array_key_exists($segment, config('app.locales'))) {
            $segments = $request->segments();
            $segments[0] = 'az';
            $correctedUrl = implode('/', $segments);
            $request->server->set('REQUEST_URI', $correctedUrl);
            $request->setMethod($prevMethod);

            return redirect()->to($correctedUrl)->withInput();
        } else {
            session(['locale' => $segment]);
            session(['language' => $segment]);
            app()->setLocale($segment);
        }

        $request->route()->forgetParameter('lang');

        return $next($request);
    }
}
