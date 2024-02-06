<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\CallRouteAction;
use S4mpp\AdminPanel\Traits\RenderButtonLink;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\RenderButtonForm;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class View extends CustomAction
{
	use ShoudOpenInNewTab, RenderButtonLink, CallRouteAction;

	public function __construct(public string $title, private ?string $view = null)
	{
		parent::__construct($title);

		$this->setAction('customActionView');
	}

	public function getUrl()
	{
		return '#';
	}

	// public function getCallbackRoute($resource)
	// {
	// 	return function($id) use ($resource)
	// 	{			
	// 		$register = $resource->getModel()::findOrFail($id);

	// 		return view('admin::custom-actions.content.view-action', [
	// 			'title' => $resource->title,
	// 			'action_title'=> $this->getTitle(),
	// 			'register'=> $register,
	// 			'resource'=> $resource,
	// 			'view' => $this->view
	// 		]);
	// 	};
	// }
}