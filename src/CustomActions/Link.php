<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class Link extends CustomAction
{
	use ShoudOpenInNewTab, SendForm, CallRouteMethod;

	public function __construct(public string $title, private string $url)
	{
		parent::__construct($title);
	}

	public function getUrl()
	{
		return $this->url;
	}
}