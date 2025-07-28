<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServiceEmployeeMiddleware
{
    public function handle(Request $request, Closure $next): Response

    {
        if (Auth::check() && Auth::user()->role == "employee_services") {
            return $next($request);
        }
        return redirect()->route('log_form');
    }

}
