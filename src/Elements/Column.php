<?php

namespace S4mpp\AdminPanel\Elements;

class Column
{
	public string $type = 'text';
	
	public array $style_class = [];

	public $callback;

	function __construct(public $title, public $field)
	{}

	public static function create(string $title, string $field)
	{
		return new Column($title, $field);
	}

	public function boolean()
	{
		$this->type = 'boolean';
		
		return $this;
	}

	public function enum()
	{
		$this->type = 'enum';
		
		return $this;
	}

	public function relation(string $fk_field)
	{
		$this->callback(function($item) use ($fk_field)
		{
			return $item->{$fk_field} ?? null;
		});

		return $this;
	}

	public function datetime(string $format = 'Y-m-d H:i')
	{
		$this->callback(function($item) use ($format)
		{
			return $item ? $item->format($format) : null;
		});

		return $this;
	}

	public function callback(callable $callback)
	{
		$this->callback = $callback;
	}

	public function align(string $alignment)
	{
		$this->style_class[] = 'text-'.$alignment;
		
		return $this;
	}

	public function strong()
	{
		$this->style_class[] = 'text-strong';
		
		return $this;
	}
}