<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\OpenALink;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;
use S4mpp\AdminPanel\Traits\CallRoutemethod;

final class Method extends CustomAction
{
	use ShoudOpenInNewTab, OpenALink, CallRoutemethod;

	public function __construct(public string $title, private string $controller, private string $method)
	{
		parent::__construct($title);
	}

	public function getCallbackRoute(): array
	{
		return [$this->controller, $this->method];
	}
}