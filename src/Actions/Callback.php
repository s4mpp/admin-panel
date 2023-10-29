<?php

namespace S4mpp\AdminPanel\Actions;

use S4mpp\AdminPanel\Traits\HasFormAction;
use S4mpp\AdminPanel\Traits\HasNewTab;
use S4mpp\AdminPanel\Traits\HasRouteAction;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;

final class Callback extends Action
{
	use HasNewTab, HasFormAction, HasRouteAction, HasSuccessMessage;

	private $method_action = 'POST';

	public function __construct(private $callback)
	{}

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