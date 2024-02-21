<?php

namespace S4mpp\AdminPanel\CustomActions;

use Closure;
use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\CallRouteAction;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\RenderButtonForm;
use S4mpp\AdminPanel\Traits\HasSuccessMessage;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class Callback extends CustomAction
{
    //use ShoudOpenInNewTab, SendForm, CallRouteMethod, HasSuccessMessage;

    use CallRouteAction, RenderButtonForm, ShoudOpenInNewTab;

    public function __construct(string $title, private ?Closure $callback)
    {
        parent::__construct($title);

        $this->setMethod('PUT');

        $this->setAction('customActionCallback');
    }

    public function getUrl(): string
    {
        return '#';
    }

    public function getCallback(): ?Closure
    {
        return $this->callback;
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
