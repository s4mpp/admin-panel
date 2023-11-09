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
    public function handle(Request $request, Closure $next, string $params): Response
    {
        $params_exp = explode('.', $params);

		$resource = $params_exp[0] ?? null;
		$action = $params_exp[1] ?? null;

        // dump($resource);
        // dump($action);

        // if($is_disabled)
        // {
        //     return response($message, 400);
        // }
        
        return $next($request);
    }
}
