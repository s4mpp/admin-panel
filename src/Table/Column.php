<?php

namespace S4mpp\AdminPanel\Table;

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

	public function datetime(string $format)
	{
		$this->callback(function($item) use ($format)
		{
			return $item->format($format);
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