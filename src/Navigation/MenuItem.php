<?php

namespace S4mpp\AdminPanel\Navigation;


class MenuItem
{
	public ?string $icon = null;

	public string $title;
	
	public ?string $action;

	public string $uri = '';
	
	public function __construct(string $title, string $route = null)
	{
		$this->type = 'item';

		$this->title = $title;
		
		$this->action = $route;

		return $this;
	}

	public function icon(string $icon)
	{
		$this->icon = 'la la-'.$icon;

		return $this;
	}

	public function uri(string $uri)
	{
		$this->uri = $uri;

		return $this;
	}
}