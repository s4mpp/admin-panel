<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\Format\Facades\Format;
use S4mpp\AdminPanel\Labels\File;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Labels\Badge;
use S4mpp\AdminPanel\Labels\Boolean;
use S4mpp\AdminPanel\Labels\Datetime;
use S4mpp\AdminPanel\Labels\LongText;
use S4mpp\AdminPanel\Labels\MarkDown;

abstract class Label
{
	public static function text(string $title, string $field)
	{
		return (new Text($title, $field));
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

	// public static function decimal(string $title, string $field, int $decimals = 2)
	// {
	// 	return (new ColumnElement($title, $field))->callback(function(float $value = null) use($decimals)
	// 	{
	// 		if(is_null($value))
	// 		{
	// 			return null;
	// 		}

	// 		return number_format($value, $decimals, ',', '.');
	// 	});
	// }

	// public static function currency(string $title, string $field, string $symbol, bool $convert_cents = true)
	// {
	// 	return (new ColumnElement($title, $field))->callback(function(float $value = null) use ($symbol, $convert_cents)
	// 	{
	// 		if(is_null($value))
	// 		{
	// 			return null;
	// 		}

	// 		return $symbol.' '.Format::currency($value, $convert_cents);
	// 	});
	// }
}