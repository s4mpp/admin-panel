<?php

namespace S4mpp\AdminPanel\Factories;

use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Filter\Search;
use S4mpp\AdminPanel\Filter\Multiple;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

abstract class Filter
{
	public static function period(string $title, string $field)
	{
		return (new Period($title, $field));
	}

	public static function multiple(
		string $title,
		string $field,
		array | Collection | EloquentCollection $options,
		string $value_collection = null,
		string $key_collection = null)
	{
		return (new Multiple($title, $field, $options, $value_collection, $key_collection));
	}

	public static function search(
		string $title,
		string $field,
		string $model,
		string $model_field = null)
	{
		return (new Search($title, $field, $model, $model_field));
	}
}