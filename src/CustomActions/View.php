<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\OpenALink;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;
use S4mpp\AdminPanel\Traits\CallRoutemethod;

final class View extends CustomAction
{
	use ShoudOpenInNewTab, OpenALink, CallRoutemethod;

	public function __construct(public string $title, private string $view)
	{
		parent::__construct($title);
	}

	public function getCallbackRoute($resource)
	{
		return function($id) use ($resource)
		{
			if($this->isDisabled())
			{
				return response($this->getDisabledMessage(), 400);
			}
			
			$register = $resource->getModel()::findOrFail($id);

			return view('admin::resources.view-action', [
				'title' => $resource->title,
				'action_title'=> $this->getTitle(),
				'register'=> $register,
				'resource'=> $resource,
				'view' => $this->view
			]);
		};
	}
}