<?php

namespace S4mpp\AdminPanel\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomActionEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $is_disabled = 0, ?string $message = null): Response
    {
        if($is_disabled)
        {
            return response($message, 400);
        }
        
        return $next($request);
    }
}
