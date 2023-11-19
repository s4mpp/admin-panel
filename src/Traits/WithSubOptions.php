<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

trait WithSubOptions
{
	private array | Collection | EloquentCollection $options = [];

	private ?string $value_collection = null;
	
	private ?string $key_collection = null;

	function __construct(
		private string $title,
		private string $name,
		array | Collection | EloquentCollection $options = [],
		string $value_collection = null,
		string $key_collection = null)
	{
		$this->options = $options;
		$this->value_collection = $value_collection;
		$this->key_collection = $key_collection;
		
		parent::__construct($title, $name);
	}

	public function getOptions()
	{
		foreach($this->options as $key => $value)
		{
			list($key, $value) = $this->_getKeyValue($key, $value);

			if($value)
			{
				$options[$key] = $value;
			}
		}
	
		return $options ?? [];
	}

	private function _getKeyValue(int | string $key, mixed $value = null): array
	{
		if(is_string($value))
		{
			return [$key, $value];
		}

		if(is_a($value, Model::class))
		{
			$k = $this->key_collection ? $value->{$this->key_collection} : $value->id;
	
			return [$k, $value->{$this->value_collection} ?? $value];
		}

		if(is_array($value))
		{
			$k = $this->key_collection ? $value[$this->key_collection] : $key;
	
			return [$k, $value[$this->value_collection] ?? json_encode($value)];
		}

		if((new \ReflectionClass($value::class))->isEnum())
		{
			return [$value->value, $value->name];
		}

		return [null, null];
	}
}