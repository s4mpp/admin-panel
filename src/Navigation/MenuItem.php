<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuItem
{	
	public string $uri = '';

	public bool $active = false;
	
	public function __construct(public string $title, public ?string $route = null, public ?int $order = null)
	{}

	public function setActiveOrNot(string $slug, string $uri): void
	{
		$this->active = strpos($uri, $slug) !== false;
	}
}