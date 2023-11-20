<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\Format\Format;
use S4mpp\AdminPanel\Input\Date;
use S4mpp\AdminPanel\Input\File;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Input\Radio;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Input\Number;
use S4mpp\AdminPanel\Input\Select;
use S4mpp\AdminPanel\Input\Checkbox;
use S4mpp\AdminPanel\Input\Textarea;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Input
{
	public static function text(string $title, string $field)
	{
		return (new Text($title, $field))->rules('string');
	}

	public static function date(string $title, string $field)
	{
		return (new Date($title, $field))->prepareForForm(function($value):string { return $value->format('Y-m-d'); });
	}

	public static function email(string $title, string $field)
	{
		return (new Email($title, $field))->rules('email');
	}

	public static function textarea(string $title, string $field, int $rows = 4)
	{
		return (new Textarea($title, $field, $rows))->rules('string');
	}

	public static function file(string $title, string $field, string $folder)
	{
		return (new File($title, $field, $folder))->rules('file');
	}

	public static function decimal(string $title, string $field, float $step = 0.01)
	{
		return (new Number($title, $field))->step($step)->rules('numeric');
	}

	public static function integer(string $title, string $field, int $step = 1)
	{
		return (new Number($title, $field))->step($step)->rules('integer');
	}

	public static function currency(string $title, string $field, bool $has_cents = true)
	{
		$rules = ($has_cents)
		? ['integer', 'min:1', 'max:21000000']
		: ['numeric', 'min:0.01', 'max:21000000.00'];

		extract($rules);

		return (new Text($title, $field))
		->mask('$money($input, \',\', \'.\')')
		->prepareForForm(function($value) use ($has_cents) { return Format::currency($value, $has_cents); })
		->prepareForValidation(function(string $value = null) use ($has_cents)
		{
			if(is_null($value) || !$value)
			{
				return null;
			}

			$nb_float = Format::numberToFloat($value);

			if($has_cents)
			{
				return intval($nb_float * 100);
			}

			return $nb_float;
		})
		->rules(...$rules);
	}

	public static function boolean(string $title, string $field)
	{
		return (new Select($title, $field, [
			0 => 'Não',
			1 => 'Sim',
		]));
	}

	public static function select(
		string $title,
		string $field,
		array | Collection | EloquentCollection $options,
		string $value_collection = null,
		string $key_collection = null)
	{
		return (new Select($title, $field, $options, $value_collection, $key_collection));
	}

	public static function checkbox(
		string $title,
		string $field,
		array | Collection | EloquentCollection $options,
		string $value_collection = null,
		string $key_collection = null)
	{
		return (new Checkbox($title, $field, $options, $value_collection, $key_collection))->rules('array');
	}

	public static function radio(
		string $title,
		string $field,
		array | Collection | EloquentCollection $options,
		string $value_collection = null,
		string $key_collection = null)
	{
		return (new Radio($title, $field, $options, $value_collection, $key_collection));
	}
}