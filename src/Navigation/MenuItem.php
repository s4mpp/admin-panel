<?php

namespace S4mpp\AdminPanel\Navigation;

use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Ordenable;
use S4mpp\AdminPanel\Traits\Titleable;

final class MenuItem
{
	use Slugable, Ordenable, Titleable;

	private $is_active = false;

	private ?string $route = null;
	
	private $target = null;

	public function __construct(private string $title)
	{
		$this->createSlug($title);

		$this->route('admin.'.$this->slug);

	}

	public function route(string $route)
	{
		$this->route = $route;

		return $this;
	}

	public function target(array | string $target)
	{
		$this->target = $target;

		return $this;
	}

	public function activate()
	{
		$this->is_active = true;
	}

	public function getTarget(): array | string
	{
		return $this->target;
	}

	public function isActive(): bool
	{
		return $this->is_active;
	}

	public function getRoute()
	{
		return $this->route;
	}
}