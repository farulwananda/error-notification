<?php

use Illuminate\Foundation\Application;
use App\Notifications\ErrorNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        if(app()->environment('production')) {
            $exceptions->report(function (Throwable $exception) {
                Notification::route('telegram', config('services.telegram.channel_id'))
                    ->notify(new ErrorNotification($exception));
            });
        }
    })->create();
