<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiGaurdMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        config(['auth.guards.api.provider' => 'users']);
        return $next($request);
    }
}
