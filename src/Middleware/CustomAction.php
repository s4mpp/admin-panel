<?php

namespace S4mpp\AdminPanel\Middleware;

use Closure;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\AdminPanel;
use Symfony\Component\HttpFoundation\Response;
use S4mpp\AdminPanel\CustomActions\CustomAction as CustomActionResource;

class CustomAction
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $params): Response
    {
        $params_exp = explode('.', $params);

		$resource_slug = $params_exp[0] ?? null;
		$action_slug = $params_exp[1] ?? null;

        $resource = AdminPanel::getResource($resource_slug.'Resource');

        $action = $this->_findAction($resource, $action_slug);

        if(!$action)
        {
            abort(404);
        }

        $register = $resource->getModel()->findOrFail($request->id);

        $action->setRegister($register);

        if($action->isDisabled())
        {
            return response($action->getDisabledMessage());
        }

        $request->attributes->add([
            'resource' => $resource,
            'register' => $register
        ]);
        
        return $next($request);
    }

    private function _findAction(Resource $resource, string $action_slug): ?CustomActionResource
    {
        $custom_actions = $resource->getCustomActions();

        foreach($custom_actions as $action)
        {
            if($action->getSlug() == $action_slug)
            {
                return $action;
            }
        }
    }
}
