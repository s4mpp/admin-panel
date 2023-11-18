<?php

namespace S4mpp\AdminPanel\Traits;
trait HasLabel
{
	/*use HasType;

	private $content = null;*/

	private $callback = null;

	/*private bool $is_relation = false;

	private bool $strong = false;

	private array $additional_data = [];

	private $relation = [];

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function getContent()
	{
		return $this->content;
	}*/

	public function callback(callable $callback)
	{
		$this->callback = $callback;

		return $this;
	}

	public function getCallback(): ?callable
	{
		return $this->callback ?? null;
	}

	/*public function getAdditionalData(string $key)
	{
		return $this->additional_data[$key] ?? null;
	}

	public function isRelation(): bool
	{
		return $this->is_relation;
	}

	public function datetime(string $format = 'd/m/Y H:i')
	{
		$this->type = 'datetime';

		$this->additional_data['format'] = $format;

		return $this;
	}

	public function currency(bool $convert_cents = true, string $prefix = 'R$')
	{
		$this->callback = function($value) use ($prefix, $convert_cents)
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
		};

		return $this;
	}

	public function limit(int $size = 100, $end = '...')
	{
		$this->callback = function($item) use ($size, $end)
		{
			return $item ? Str::limit($item, $size, $end) : null;
		};
		
		return $this;
	}

	public function relation(string $fk_relation, string $fk_field = null)
	{
		$this->is_relation = true;

		$this->fk_field = $fk_relation;

		$this->callback = function($item) use ($fk_relation, $fk_field)
		{
			$data = $item->{$fk_relation} ?? null;

			if($fk_field)
			{
				$data = $data->{$fk_field};
			}

			return $data;
		};

		return $this;
	}*/

	

	/*public function strong()
	{
		$this->strong = true;
		
		return $this;
	}

	public function boolean()
	{
		$this->type = 'boolean';

		return $this;
	}

	public function dump()
	{
		$this->type = 'dump';

		return $this;
	}

	public function markDown()
	{
		$this->type = 'markdown';

		return $this;
	}

	public function file()
	{
		$this->type = 'file';

		return $this;
	}
	
	public function enum()
	{
		$this->type = 'enum';

		return $this;
	}*/

	public function datetime(string $format)
	{
		$this->callback(function($register) use ($format) : string
		{
			return $register?->format($format);
		});

		return $this;
	}

	public function enum()
	{
		$this->callback(function($register): string
		{
			return $register->name;
		});

		return $this;
	}
}