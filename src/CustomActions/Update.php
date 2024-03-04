<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\CanBeDisabled;
use S4mpp\AdminPanel\Traits\CanBeDangerous;
use S4mpp\AdminPanel\Traits\CallRouteAction;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\RenderButtonForm;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class Update extends CustomAction
{
    use CallRouteAction, RenderButtonForm, ShoudOpenInNewTab, CanBeDisabled, CanBeDangerous;

    /**
     * @param  array<mixed>  $data
     */
    public function __construct(string $title, private array $data)
    {
        parent::__construct($title);

        $this->setMethod('PUT');

        $this->setAction('customActionUpdate');
    }

    /**
     * @return array<mixed>
     */
    public function getDataToChange(): array
    {
        return $this->data;
    }

    // public function getCallbackRoute($resource)
    // {
    // 	return function($id) use ($resource)
    // 	{
    // 		try
    // 		{
    // 			$register = $resource->getModel()::findOrFail($id);

    // 			foreach($this->data as $key => $new_value)
    // 			{
    // 				$register->{$key} = $new_value;
    // 			}

    // 			$register->save();

    // 			return redirect()->back()->with('message', $this->getSuccessMessage());
    // 		}
    // 		catch(\Exception $e)
    // 		{
    // 			return redirect()->back()->withErrors($e->getMessage());
    // 		}
    // 	};
    // }
}
