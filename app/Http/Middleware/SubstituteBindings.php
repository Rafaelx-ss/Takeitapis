<?php

namespace Illuminate\Routing\Middleware;

use Closure;

class SubstituteBindings
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
