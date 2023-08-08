<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuItem
{	
	public string $uri = '';

	public bool $active = false;
	
	public function __construct(public string $title, public string $route, public string $icon = 'angle-right')
	{
		$this->title = $title;
	
		return $this;
	}

	public function isActive(): bool
	{
		$current_route = request()->path() ?? null;

		return $this->route && (strpos($this->route, $current_route) !== false);
	}
}