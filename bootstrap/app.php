<?php

use App\Http\Middleware\GetConfigs;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if (!env('APP_DEBUG')) {
            # code...
            // $exceptions->respond(function (Response $response) {
            //     if ($response->getStatusCode() < 200 || $response->getStatusCode() >300) {
            //         return redirect('/');
            //     }
                
    
            //     return $response;
            // });
        }
    })
    ->create();
