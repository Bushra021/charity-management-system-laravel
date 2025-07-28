<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('log_form'); // أو رد مناسب
        }

        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        return redirect()->route('log_form');
    }
}
