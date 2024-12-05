<?php

use App\Http\Middleware\HasToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        using: function() {

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));


            Route::middleware('api')
                ->prefix('api/company')
                ->group(base_path('routes/companies.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        }
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
        ['prefix' => 'api', 'middleware' => ['api', 'auth:sanctum']]
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api([
            HasToken::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
