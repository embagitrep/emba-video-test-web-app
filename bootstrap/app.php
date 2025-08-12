<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'language' => \App\Http\Middleware\LanguageMiddleware::class,
            'auth.admin' => \App\Http\Middleware\AdminMiddleware::class,
            'ajax.request' => \App\Http\Middleware\CheckAjaxRequestMiddleware::class,
            'ajax.post.request' => \App\Http\Middleware\IsAjaxPostMiddleware::class,
            'ajax.auth' => \App\Http\Middleware\AjaxAuthMiddleware::class,
            'redirect.unauth' => \App\Http\Middleware\RedirectUnauthMiddleware::class,
            'api.auth' => \App\Http\Middleware\ApiAuthMiddleware::class,
            'api.version' => \App\Http\Middleware\ApiVersionMiddleware::class,
        ])->validateCsrfTokens(except: [
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSingletons([
        \Illuminate\Contracts\Debug\ExceptionHandler::class => \App\Exceptions\Handler::class,
    ])
    ->create();
