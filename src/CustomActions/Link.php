<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\SendForm;
use S4mpp\AdminPanel\Traits\CallRouteMethod;
use S4mpp\AdminPanel\Traits\RenderButtonLink;
use S4mpp\AdminPanel\Traits\SendFormOnClick;
use S4mpp\AdminPanel\Traits\RenderButtonForm;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class Link extends CustomAction
{
	use ShoudOpenInNewTab, RenderButtonLink;
	// SendForm,
	//  CallRouteMethod;

	public function __construct(private string $title, private string $url)
	{
		parent::__construct($title);
	}

	public function getUrl()
	{
		return $this->url;
	}
}