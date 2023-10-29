<?php

namespace S4mpp\AdminPanel\Actions;

use S4mpp\AdminPanel\Traits\HasNewTab;
use S4mpp\AdminPanel\Traits\HasLinkAction;
use S4mpp\AdminPanel\Traits\HasRouteAction;

final class Method extends Action
{
	use HasNewTab, HasLinkAction, HasRouteAction;

	public function __construct(private string $controller, private string $method)
	{}

	public function getCallbackRoute(): array
	{
		return [$this->controller, $this->method];
	}
}