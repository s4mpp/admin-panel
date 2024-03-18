<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Support\Collection;
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
        return ! is_null($this->callbacks);
    }

    /**
     * @return array<Closure>
     */
    public function getCallbacks(): array
    {
        return $this->callback;
    }

    /**
     * @param  Model|array<mixed>  $register
     */
    public function runCallbacks(mixed $content = null, Model|Collection|array $register): mixed
    {
        foreach ($this->callbacks as $callback) {
            $content = call_user_func($callback, $content, $register);
        }

        return $content;
    }
}
