<?php

namespace S4mpp\AdminPanel\Filter;

class Filter
{
	// public string $slug;

	// public ?string $icon = null;
	
	// public string $color = 'indigo';
	
	// public string $method = 'GET';

	// public array $show_in = ['table', 'read'];

	// public bool $is_danger = false;

	// public ?string $question = null;

	function __construct(public string $title, public ?string $field)
	{}

	public static function create(string $title, string $field)
	{
		return new Filter($title, $field);
	}

	/*public function target(string | array $target)
	{
		$this->target = $target;

		return $this;
	}

	public function danger()
	{
		$this->is_danger = true;

		if(!$this->question)
		{
			$this->question('Tem certeza?');
		}

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

	public function color(string $color)
	{
		$this->color = $color;

		return $this;
	}

	public function showIn(array $show_in)
	{
		$this->show_in = $show_in;

		return $this;
	}*/
}