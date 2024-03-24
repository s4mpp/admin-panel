<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @todo callback get key
 * @todo callback get value
 */
trait HasMultipleOptions
{
    /**
     * @var array<mixed>|Collection
     */
    private array|Collection $options = [];

    private ?string $value_collection = null;

    private ?string $key_collection = null;

    private ?Closure $callback_option = null;

    /**
     * @param  array<mixed>|Collection  $options
     */
    public function options(array|Collection $options = [], ?string $value_collection = null, ?string $key_collection = null, ?Closure $callback = null): self
    {
        $this->options = $options;

        $this->value_collection = $value_collection;
        $this->key_collection = $key_collection;

        $this->callback_option = $callback;

        return $this;
    }

    /**
     * @return array<string|null>
     */
    public function getOptions(): array
    {
        foreach ($this->options as $key => $value) {
            $key = $this->getKey($key, $value);

            $options[$key] = ($this->callback_option) ? call_user_func($this->callback_option, $value, $key) : $this->getValue($value);
        }

        return $options ?? [];
    }

    private function getKey(int|string $key, mixed $value = null): null|int|string
    {
        if (is_string($value)) {
            return $key;
        }

        if (is_array($value)) {
            return $this->key_collection ? $value[$this->key_collection] : $key;
        }

        if ((new \ReflectionClass($value::class))->isEnum()) {
            return $value->value;
        }
        
        /** @var object $value */
        if (is_a($value, Model::class)) {
            return $this->key_collection ? $value->{$this->key_collection} : $value->id;
        }

        return null;
    }

    private function getValue(mixed $value): ?string
    {
        if (is_string($value)) {
            return $value;
        }

        if (is_array($value)) {
            return $value[$this->value_collection] ?? json_encode($value);
        }

        if ((new \ReflectionClass($value::class))->isEnum()) {
            return $value->name;
        }
        
        /** @var object $value */
        if (is_a($value, Model::class)) {
            return $value[$this->value_collection] ?? $value;
        }


        return null;
    }
}
