<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\CustomActions\Method;
use S4mpp\AdminPanel\CustomActions\Prompt;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Livewire;

abstract class CustomAction
{
	public static function link(string $title, string $url)
	{
		return (new Link($title, $url));
	}

	public static function method(string $title, string $controller, string $method)
	{
		return (new Method($title, $controller, $method));
	}

	public static function view(string $title, string $view)
	{
		return (new View($title, $view));
	}

	public static function update(string $title, array $data)
	{
		return (new Update($title, $data));
	}

	public static function callback(string $title, callable $callback)
	{
		return (new Callback($title, $callback));
	}

	public static function livewire(string $title, string $component)
	{
		return (new Livewire($title, $component));
	}
	
	public static function prompt(string $title, string $field, string $question)
	{
		return (new Prompt($title, $question, $field));
	}
}