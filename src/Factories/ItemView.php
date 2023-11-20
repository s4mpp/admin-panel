<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\ItemView\File;
use S4mpp\AdminPanel\ItemView\Badge;
use S4mpp\AdminPanel\ItemView\Boolean;
use S4mpp\AdminPanel\ItemView\Datetime;
use S4mpp\AdminPanel\ItemView\LongText;
use S4mpp\AdminPanel\ItemView\MarkDown;
use S4mpp\AdminPanel\ItemView\ItemView as ItemViewElement;

abstract class ItemView
{
	public static function text(string $title, string $field)
	{
		return (new ItemViewElement($title, $field));
	}

	public static function longText(string $title, string $field)
	{
		return (new LongText($title, $field));
	}
	
	public static function markDown(string $title, string $field)
	{
		return (new MarkDown($title, $field));
	}

	public static function date(string $title, string $field)
	{
		return (new Datetime($title, $field, 'd/m/Y'));
	}

	public static function datetime(string $title, string $field)
	{
		return (new Datetime($title, $field, 'd/m/Y H:i'));
	}

	public static function badge(string $title, string $field)
	{
		return (new Badge($title, $field));
	}

	public static function boolean(string $title, string $field)
	{
		return (new Boolean($title, $field));
	}

	public static function file(string $title, string $field, string $driver = 'local')
	{
		return (new File($title, $field, $driver));
	}
}