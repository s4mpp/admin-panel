<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait HasLabel
{
	private string $type = 'text';
	
	private ?string $default_text = null;
	
	private $callback = null;

	private bool $is_relation = false;

	private bool $strong = false;

	public function getCallback(): ?callable
	{
		return $this->callback ?? null;
	}

	public function getDefaultText(): ?string
	{
		return $this->default_text ?? null;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function isRelation(): bool
	{
		return $this->is_relation;
	}

	public function datetime(string $format = 'd/m/Y H:i')
	{
		$this->callback = function($item) use ($format)
		{
			return $item ? $item->format($format) : null;
		};

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

	public function limit(int $size = 100, $end = '...')
	{
		$this->callback = function($item) use ($size, $end)
		{
			return $item ? Str::limit($item, $size, $end) : null;
		};
		
		return $this;
	}

	public function relation(string $fk_field)
	{
		$this->is_relation = true;

		$this->fk_field = $fk_field;

		$this->callback = function($item) use ($fk_field)
		{
			return $item->{$fk_field} ?? null;
		};

		return $this;
	}

	public function strong()
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
	
	/**
	 * 
	 * @deprecated
	 */
	public function enum()
	{
		$this->type = 'enum';

		return $this;
	}
}