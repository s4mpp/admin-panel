<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasCallbacks
{
	/**
	 * @var array<Closure>
	 */
	private array $callbacks = [];

    public function callback(Closure $callback): self
    {
        $this->callbacks[] = $callback;

		return $this;
    }

	public function hasCallbacks(): bool
	{
		return !is_null($this->callbacks);
	}

	/**
	 * @return array<Closure>
	 */
	public function getCallbacks(): array
	{
		return $this->callback;
	}

	public function runCallbacks(mixed $content = null, Model $register): mixed
	{
		foreach($this->callbacks as $callback)
		{
			$content = call_user_func($callback, $content, $register);
		}

		return $content;
	}
}
