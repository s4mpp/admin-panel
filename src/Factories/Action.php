<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\Actions\Link;
use S4mpp\AdminPanel\Actions\View;
use S4mpp\AdminPanel\Actions\Method;
use S4mpp\AdminPanel\Actions\Prompt;
use S4mpp\AdminPanel\Actions\Update;
use S4mpp\AdminPanel\Actions\Callback;
use S4mpp\AdminPanel\Actions\Livewire;

abstract class Action
{
	public static function link(string $title, string $url)
	{
		return (new Link($url))->setTitle($title);
	}

	public static function method(string $title, string $controller, string $method)
	{
		return (new Method($controller, $method))->setTitle($title);
	}

	public static function view(string $title, string $view)
	{
		return (new View($view))->setTitle($title);
	}

	public static function update(string $title, array $data)
	{
		return (new Update($data))->setTitle($title);
	}

	public static function callback(string $title, callable $callback)
	{
		return (new Callback($callback))->setTitle($title);
	}

	public static function livewire(string $title, string $component)
	{
		return (new Livewire($component))->setTitle($title);
	}
	
	public static function prompt(string $title, string $field, string $question)
	{
		return (new Prompt($question, $field))->setTitle($title);
	}






	/*private string $slug;
		
	private ?string $method = 'GET';
	
	private ?array $target = null;

	private array $show_in = ['table', 'read'];

	private bool $is_danger = false;

	private ?string $question = null;

	private bool $new_tab = false;

	private $is_disabled = null;

	private $disabled_callback;

	private ?string $disabled_message = null;

	function __construct(private string $title, private ?string $route = null)
	{
		$this->slug = Str::slug($title);

		$this->route = $route ?? $this->slug;
	}

	public static function create(string $title, string $route = null)
	{
		return new Action($title, $route);
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getRoute(): ?string
	{
		return $this->route;
	}

	public function view(string $view)
	{
		$this->view = $view;

		return $this;
	}

	public function isView(): bool
	{
		return !empty($this->view);
	}

	public function getView(): ?string
	{
		return $this->view;
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
	
	public function isDisabled($register = null): bool
	{
		if(is_bool($this->is_disabled))
		{
			return $this->is_disabled;
		}

		return (is_callable($this->disabled_callback) && $register)
			? call_user_func($this->disabled_callback, $register)
			: false;
	}

	public function getDisabledMessage(): ?string
	{
		return $this->disabled_message;
	}

	public function target(array $target)
	{
		$this->target = $target;

		return $this;
	}

	public function getTarget(): ?array
	{
		return $this->target;
	}
	
	public function danger(string $question = 'Tem certeza?')
	{
		$this->is_danger = true;

		if(!$this->question)
		{
			return $this->question($question);
		}

		return $this;
	}

	public function getIsDanger(): bool
	{
		return $this->is_danger;
	}

	public function question(string $question)
	{
		$this->question = $question;

		return $this;
	}

	public function getQuestion(): ?string
	{
		return $this->question;
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

	public function getMethod(): ?string
	{
		return $this->method;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}
	
	public function showIn(array $show_in)
	{
		$this->show_in = $show_in;

		return $this;
	}

	public function getShowIn(): array
	{
		return $this->show_in;
	}

	public function newTab()
	{
		$this->new_tab = true;

		return $this;
	}

	public function getNewTab(): bool
	{
		return $this->new_tab;
	}*/
}