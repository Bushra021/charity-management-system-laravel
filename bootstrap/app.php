<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EmployeeMiddleware;
use App\Http\Middleware\EnsurePatientProfileIsCompleted;
use App\Http\Middleware\PatientMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\ServiceEmployeeMiddleware;
use App\Http\Middleware\SetLocale;
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
            'admin' => AdminMiddleware::class,
            'patient' => PatientMiddleware::class,
            'employee' => EmployeeMiddleware::class,
            'employee_services' => ServiceEmployeeMiddleware::class,
            'ensure.patient.profile.completed' => EnsurePatientProfileIsCompleted::class,
            'role' => RoleMiddleware::class,


        ]);
        $middleware->web(append:SetLocale::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
