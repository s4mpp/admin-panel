<?php

namespace S4mpp\AdminPanel\Navigation;

use S4mpp\AdminPanel\Traits\HasSlug;

final class MenuItem
{
	use HasSlug;

	private $is_active = false;

	private ?string $route = null;
	
	private $target = null;

	public function __construct(private string $title)
	{
		$this->createSlug($title);
	}

	public function route(string $route)
	{
		$this->route = $route;

		return $this;
	}

	public function target(array | string $target)
	{
		$this->target = $target;

		$this->route('admin.'.$this->slug);

		return $this;
	}

	public function activate()
	{
		$this->is_active = true;
	}

	public function getTitle(): string
	{
		return $this->title;
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

	

	

	// public string $uri = '';

	// public bool $active = false;
	
	// public function __construct(public string $title, public ?string $route = null, public ?int $order = null)
	// {}

	// public function setActiveOrNot(string $slug, string $uri): void
	// {
	// 	$this->active = strpos($uri, $slug) !== false;
	// }

	// public function getOrder(): int
	// {
	// 	return $this->order ?? 0;
	// }
}