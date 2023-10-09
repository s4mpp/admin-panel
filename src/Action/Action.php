<?php

namespace S4mpp\AdminPanel\Action;

use Illuminate\Support\Str;

class Action
{
	public string $slug;

	public ?string $icon = null;
	
	public string $color = 'indigo';
	
	public string $method = 'GET';

	public array $show_in = ['table', 'read'];

	public bool $is_danger = false;

	public ?string $question = null;

	public bool $new_tab = false;

	public $is_disabled = false;

	public $disabled_callback;

	public ?string $disabled_message = null;

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

	public function disabled(bool | callable $disabled_callback = true, ?string $disabled_message = null)
	{
		if(is_bool($disabled_callback))
		{
			$this->is_disabled = $disabled_callback;
		}
		
		$this->disabled_callback = $disabled_callback;

		$this->disabled_message = $disabled_message ?? 'Função não disponível no momento.';

		return $this;
	}

	public function target(string | array $target)
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
	}

	public function newTab()
	{
		$this->new_tab = true;

		return $this;
	}
}