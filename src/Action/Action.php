<?php

namespace S4mpp\AdminPanel\Action;

use Illuminate\Support\Str;

class Action
{
	public string $slug;

	public ?string $icon = null;
	
	public string $context = 'primary';
	
	public string $method = 'GET';

	public array $show_in = ['table', 'read'];

	function __construct(public string $title, public ?string $route = null)
	{
		$this->slug = Str::slug($title);

		if(!$this->route)
		{
			$this->route = $this->slug;
		}
	}

	public static function create(string $title, string $route = null)
	{
		return new Action($title, $route);
	}

	public function target(string | array $target)
	{
		$this->target = $target;

		return $this;
	}

	public function question(string $question)
	{
		$this->question = $question;

		return $this;
	}

	public function icon(string $icon)
	{
		$this->icon = $icon;

		return $this;
	}

	public function method(string $method)
	{
		$this->method = strtoupper($method);

		return $this;
	}

	public function context(string $context)
	{
		$this->context = $context;

		return $this;
	}

	public function showIn(array $show_in)
	{
		$this->show_in = $show_in;

		return $this;
	}
}