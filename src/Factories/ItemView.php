<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\Format\Format;
use S4mpp\AdminPanel\Resource;
use S4mpp\AdminPanel\ItemView\File;
use S4mpp\AdminPanel\ItemView\Badge;
use S4mpp\AdminPanel\ItemView\Boolean;
use S4mpp\AdminPanel\ItemView\Datetime;
use S4mpp\AdminPanel\ItemView\LongText;
use S4mpp\AdminPanel\ItemView\MarkDown;
use S4mpp\AdminPanel\ItemView\Relation;
use S4mpp\AdminPanel\ItemView\ItemView as ItemViewElement;

abstract class ItemView
{
	public static function text(string $title, string $field)
	{
		return (new ItemViewElement($title, $field));
	}

	public static function relation(string $title, string $field, string $resource, string $field_main = null)
	{
		return (new Relation($title, $field, $resource, $field_main));
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

	public static function file(string $title, string $field)
	{
		return (new File($title, $field));
	}

	public static function decimal(string $title, string $field, int $decimals = 2)
	{
		return (new ItemViewElement($title, $field))->callback(function(float $value) use($decimals)
		{
			return number_format($value, $decimals, ',', '.');
		});
	}

	public static function currency(string $title, string $field, string $symbol, bool $convert_cents = true)
	{
		return (new ItemViewElement($title, $field))->callback(function(float $value) use ($symbol, $convert_cents)
		{
			return $symbol.' '.Format::currency($value, $convert_cents);
		});
	}
}