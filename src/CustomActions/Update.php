<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\OpenInNewTab;
use S4mpp\AdminPanel\Traits\CallRoutemethod;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;

final class Update extends CustomAction
{
	use OpenInNewTab, SendForm, CallRoutemethod, HasSuccessMessage;

	public function __construct(public string $title, private array $data)
	{
		parent::__construct($title);
	}

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