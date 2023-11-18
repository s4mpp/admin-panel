<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\ItemView\Boolean;
use S4mpp\AdminPanel\ItemView\ItemView as ItemViewElement;

abstract class ItemView
{
	public static function text(string $title, string $field)
	{
		return (new ItemViewElement($title, $field));
	}

	public static function date(string $title, string $field)
	{
		return (new ItemViewElement($title, $field))->datetime('d/m/Y');
	}

	public static function datetime(string $title, string $field)
	{
		return (new ItemViewElement($title, $field))->datetime('d/m/Y H:i');
	}

	public static function enum(string $title, string $field)
	{
		return (new ItemViewElement($title, $field))->enum();
	}

	public static function boolean(string $title, string $field)
	{
		return (new Boolean($title, $field));
	}
}