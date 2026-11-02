<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->guest(route('demo.login'));
        }

        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized access: your role does not permit this action.');
        }

        return $next($request);
    }
}
