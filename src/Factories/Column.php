<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\Format\Facades\Format;
use S4mpp\AdminPanel\Column\Badge;
use S4mpp\AdminPanel\Column\Boolean;
use S4mpp\AdminPanel\Column\Datetime;
use S4mpp\AdminPanel\Column\LongText;
use S4mpp\AdminPanel\Column\MarkDown;
use S4mpp\AdminPanel\Column\Column as ColumnElement;

abstract class Column
{
	public static function text(string $title, string $field)
	{
		return (new ColumnElement($title, $field));
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

	public static function decimal(string $title, string $field, int $decimals = 2)
	{
		return (new ColumnElement($title, $field))->callback(function(float $value) use($decimals)
		{
			return number_format($value, $decimals, ',', '.');
		});
	}

	public static function currency(string $title, string $field, string $symbol, bool $convert_cents = true)
	{
		return (new ColumnElement($title, $field))->callback(function(float $value) use ($symbol, $convert_cents)
		{
			return $symbol.' '.Format::currency($value, $convert_cents);
		});
	}
}