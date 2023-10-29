<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait HasRouteAction
{
	public function getRouteName(): string
	{
		return 'custom_action.'.$this->getSlug();
	}

	public function getUrl(): string
	{
		return route($this->getRouteName(), ['id' => $this->register->id]);
	}

	public function getRouteMethod(): string
	{
		return Str::lower($this->method_action ?? 'GET');
	}
}