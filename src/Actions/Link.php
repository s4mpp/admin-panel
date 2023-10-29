<?php

namespace S4mpp\AdminPanel\Actions;

use S4mpp\AdminPanel\Traits\HasNewTab;
use S4mpp\AdminPanel\Traits\HasLinkAction;
use S4mpp\AdminPanel\Traits\HasRouteAction;
use S4mpp\AdminPanel\Actions\ActionInterface;

final class Link extends Action
{
	use HasNewTab, HasLinkAction, HasRouteAction;

	public function __construct(private string $url)
	{}

	public function getUrl()
	{
		return $this->url;
	}
}