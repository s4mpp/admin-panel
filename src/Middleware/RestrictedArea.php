<?php

namespace S4mpp\AdminPanel\Middleware;

use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate;
use S4mpp\Laraguard\Routes;

/**
 * @codeCoverageIgnore
 */
final class RestrictedArea extends Authenticate
{
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route(Routes::identifier('admin-panel')->login());
    }
}
