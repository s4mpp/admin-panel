<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\OpenALink;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class View extends CustomAction
{
	use ShoudOpenInNewTab, OpenALink, CallRouteMethod;

	public function __construct(public string $title, private string $view)
	{
		parent::__construct($title);
	}

	public function getCallbackRoute($resource)
	{
		return function($id) use ($resource)
		{			
			$register = $resource->getModel()::findOrFail($id);

			return view('admin::custom-actions.content.view-action', [
				'title' => $resource->title,
				'action_title'=> $this->getTitle(),
				'register'=> $register,
				'resource'=> $resource,
				'view' => $this->view
			]);
		};
	}
}