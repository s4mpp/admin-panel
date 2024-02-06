<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\RenderButtonForm;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Traits\CallRouteAction;

final class Callback extends CustomAction
{
	//use ShoudOpenInNewTab, SendForm, CallRouteMethod, HasSuccessMessage;

	use RenderButtonForm, ShoudOpenInNewTab, CallRouteAction;

	public function __construct(private string $title, private $callback)
	{
		parent::__construct($title);

		$this->setMethod('PUT');

		$this->setAction('customActionCallback');
	}

	public function getUrl()
	{
		return '#';
	}

	// public function getCallbackRoute($resource)
	// {
	// 	return function($id) use ($resource)
	// 	{
	// 		try
	// 		{
	// 			$register = $resource->getModel()::findOrFail($id);
	
	// 			$result = call_user_func($this->callback, $register);
	
	// 			return redirect()->back()->with('message', $this->getSuccessMessage($result));
	// 		}
	// 		catch(\Exception $e)
	// 		{
	// 			return redirect()->back()->withErrors($e->getMessage());
	// 		}
	// 	};
	// }
}