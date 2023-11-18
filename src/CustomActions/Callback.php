<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;
use S4mpp\AdminPanel\CustomActions\CustomAction;

final class Callback extends CustomAction
{
	use ShoudOpenInNewTab, SendForm, CallRouteMethod, HasSuccessMessage;

	public function __construct(string $title, private $callback)
	{
		parent::__construct($title);

		$this->setMethodAction('PUT');
	}

	public function getCallbackRoute($resource)
	{
		return function($id) use ($resource)
		{
			try
			{
				throw_if($this->isDisabled(), $this->getDisabledMessage());

				$register = $resource->getModel()::findOrFail($id);
	
				call_user_func($this->callback, $register);
	
				return redirect()->back()->with('message', $this->getSuccessMessage());
			}
			catch(\Exception $e)
			{
				return redirect()->back()->withErrors($e->getMessage());
			}
		};
	}
}