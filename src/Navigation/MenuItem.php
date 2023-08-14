<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuItem
{	
	public string $uri = '';

	public bool $active = false;
	
	public function __construct(public string $title, public string $route, public string $route_prefix, public string $icon = 'angle-right')
	{
		$this->title = $title;
	
		return $this;
	}

	public function setActiveOrNot(string $current_route_prefix): void
	{
		$this->active = ($this->route_prefix == $current_route_prefix);
	}
}