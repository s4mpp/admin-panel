<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait HasLabel
{
	private $callback = null;

	public function callback(callable $callback)
	{
		$this->callback = $callback;

		return $this;
	}

	public function getCallback(): ?callable
	{
		return $this->callback ?? null;
	}

	public function limit(int $size = 100, $end = '...')
	{
		$this->callback = function($item) use ($size, $end)
		{
			return $item ? Str::limit($item, $size, $end) : null;
		};
		
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


	public function strong()
	{
		$this->strong = true;
		
		return $this;
	}

	public function enum()
	{
		$this->callback(function($register): ?string
		{
			if(method_exists($register, 'label'))
			{
				return $register->label();
			}

			return $register->name ?? null;
		});

		return $this;
	}
}