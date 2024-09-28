<?php

namespace App\Http\Middleware;

use Closure;

class SanitizeQuery
{
    public function handle($request, Closure $next)
    {
        $queryParams = $request->query();
        foreach ($queryParams as $key => $value) {
            $queryParams[$key] = strip_tags(trim($value));
        }
        $request->merge($queryParams);
        return $next($request);
    }
}
