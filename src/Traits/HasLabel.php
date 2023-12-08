<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait HasLabel
{
	private bool $strong = false;

	private array $callbacks = [];

	public function callback(callable $callback)
	{
		$this->callbacks[] = $callback;

		return $this;
	}

	public function hasCallbacks(): bool
	{
		return count($this->callbacks) > 0;
	}

	public function runCallbacks(string $data = null)
    {
        foreach($this->getCallbacks() as $callback)
        {
            $data = call_user_func($callback, $data);
        }

        return $data;
    }

	public function getCallbacks(): array
	{
		return $this->callbacks ?? [];
	}

	public function limit(int $size = 100, $end = '...')
	{
		$this->callback(function($item) use ($size, $end)
		{
			return $item ? Str::limit($item, $size, $end) : null;
		});
		
		return $this;
	}

	public function uppercase()
	{
		$this->callback(function($str){return Str::upper($str);});
		
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

	public function strong()
	{
		$this->strong = true;

		return $this;
	}

	public function getIsStrong(): bool
	{
		return $this->strong;
		
	}
}