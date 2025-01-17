<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthorized',
                'data'    => [],
                'errors'  => [],
                'code'    => 401,
            ], 401);

        }

        return $next($request);
    }
}
