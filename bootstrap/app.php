<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('api')
                ->prefix('admins')
                ->name('admins.')
                ->group(base_path('routes/admins.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "admin"  => \App\Http\Middleware\Admin::class,
            'Checkout' => \App\Http\Middleware\Checkout::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/pay-via-ajax', '/success', '/cancel', '/fail', '/ipn'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
