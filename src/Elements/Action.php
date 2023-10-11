<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Support\Str;

class Action
{
	private string $slug;
		
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
	}
}