<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDemoModeIsEnabled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!config('demo.enabled', true)) {
            abort(404, 'Demo mode is disabled in this environment.');
        }

        return $next($request);
    }
}
