<?php

namespace S4mpp\AdminPanel\Actions;

use S4mpp\AdminPanel\Traits\HasNewTab;
use S4mpp\AdminPanel\Traits\HasFormAction;
use S4mpp\AdminPanel\Traits\HasRouteAction;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;

final class Update extends Action
{
	use HasNewTab, HasFormAction, HasRouteAction, HasSuccessMessage;

	private $method_action = 'PUT';

	public function __construct(private array $data)
	{}

	public function getCallbackRoute($resource)
	{
		return function($id) use ($resource)
		{
			try
			{
				throw_if($this->isDisabled(), $this->getDisabledMessage());

				$register = $resource->getModel()::findOrFail($id);
	
				foreach($this->data as $key => $new_value)
				{
					$register->{$key} = $new_value;
				}
	
				$register->save();
	
				return redirect()->back()->with('message', $this->getSuccessMessage());
			}
			catch(\Exception $e)
			{
				return redirect()->back()->withErrors($e->getMessage());
			}
		};
	}
}