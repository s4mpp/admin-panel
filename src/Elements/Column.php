<?php

namespace S4mpp\AdminPanel\Elements;

use Illuminate\Support\Str;

class Column
{
	public string $type = 'text';

	public bool $is_relation = false;
	
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

	public function dump()
	{
		$this->type = 'dump';

		return $this;
	}

	public function limit(int $size = 100, $end = '...')
	{
		$this->callback(function($item) use ($size, $end)
		{
			return $item ? Str::limit($item, $size, $end) : null;
		});
		
		return $this;
	}

	public function relation(string $fk_field)
	{
		$this->is_relation = true;

		$this->fk_field = $fk_field;

		$this->callback(function($item) use ($fk_field)
		{
			return $item->{$fk_field} ?? null;
		});

		return $this;
	}

	public function datetime(string $format = 'd/m/Y H:i')
	{
		$this->callback(function($item) use ($format)
		{
			return $item ? $item->format($format) : null;
		});

		return $this;
	}

	public function currency(bool $convert_cents = true, string $prefix = 'R$')
	{
		$this->callback(function($value) use ($prefix, $convert_cents)
		{
			if(!is_numeric($value))
			{
				return null;
			}

			if($convert_cents)
			{
				$value /= 100;
			}

			return $prefix.' '.number_format($value, 2, ',', '.');
		});

		return $this;
	}

	public function callback(callable $callback)
	{
		$this->callback = $callback;

		return $this;
	}

	public function align(string $alignment)
	{
		$this->alignment = $alignment;
		
		return $this;
	}

	public function strong()
	{
		$this->strong = true;
		
		return $this;
	}
}