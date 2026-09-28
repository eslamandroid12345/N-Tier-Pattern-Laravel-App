<?php

use App\Http\Middleware\Access;
use App\Http\Middleware\LocalizeApi;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            Route::group(['prefix' => 'api'], function () {

                // ----------------- website and mobile group routes ------------------------//
                Route::prefix('website')->group(base_path('routes/website.php'));
                Route::prefix('mobile')->group(base_path('routes/mobile.php'));

            });
        },
        commands: __DIR__.'/../routes/console.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'localize-api' => LocalizeApi::class,
            'permission' => Access::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
