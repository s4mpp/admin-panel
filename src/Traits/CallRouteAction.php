<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait CallRouteAction
{
	private ?string $action = null;

	private string $method = 'GET';

	public function getMethod(): string
	{
		return $this->method;
	}

	public function setMethod(string $method)
	{
		$this->method = $method;

		return $this;
	}

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