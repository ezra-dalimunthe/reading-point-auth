<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AppHeader
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);
        $response->header('X-App-Instance-Hostname', gethostname());

        return $response;
    }
}