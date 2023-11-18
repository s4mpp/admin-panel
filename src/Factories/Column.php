<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\Column\Boolean;
use S4mpp\AdminPanel\Column\Column as ColumnElement;

abstract class Column
{
	public static function text(string $title, string $field)
	{
		return (new ColumnElement($title, $field));
	}

	public static function date(string $title, string $field)
	{
		return (new ColumnElement($title, $field))->datetime('d/m/Y');
	}

	public static function datetime(string $title, string $field)
	{
		return (new ColumnElement($title, $field))->datetime('d/m/Y H:i');
	}
	
	public static function enum(string $title, string $field)
	{
		return (new ColumnElement($title, $field))->enum();
	}

	public static function boolean(string $title, string $field)
	{
		return (new Boolean($title, $field));
	}
}