<?php

namespace S4mpp\AdminPanel\Actions;

use S4mpp\AdminPanel\Traits\HasNewTab;
use S4mpp\AdminPanel\Traits\HasLinkAction;
use S4mpp\AdminPanel\Traits\HasRouteAction;

final class View extends Action
{
	use HasNewTab, HasLinkAction, HasRouteAction;

	public function __construct(private string $view)
	{}

	public function getCallbackRoute($resource)
	{
		return function($id) use ($resource)
		{
			if($this->isDisabled())
			{
				return response($this->getDisabledMessage(), 400);
			}

			$routes = $resource->getRoutes();
			
			$register = $resource->getModel()::findOrFail($id);

			return view('admin::actions.view', [
				'title' => $resource->title,
				'action_title'=> $this->getTitle(),
				'register'=> $register,
				'routes'=> $routes,
				'view' => $this->view
			]);
		};
	}
}