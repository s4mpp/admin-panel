<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait CallRouteAction
{
	private ?string $action = null;

	// public function getRouteName(): string
	// {
	// 	return 'custom_action.'.$this->getSlug();
	// }

	// public function getUrl(): string
	// {
	// 	return route($this->getRouteName(), ['id' => $this->register->id]);
	// }

	// public function getRouteMethod(): string
	// {
	// 	return Str::lower($this->method_action);
	// }

	public function getAction(): ?string
	{
		return $this->action;
	}

	public function setAction(string $action)
	{
		$this->action = $action;

		return $this;
	}
}