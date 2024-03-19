<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

trait HasMultipleOptions
{
    private array | Collection | EloquentCollection $options = [];

    private ?string $value_collection = null;

    private ?string $key_collection = null;

    private ?Closure $callback_option = null;

    public function options(array|Collection|EloquentCollection $options = [], string $value_collection = null, string $key_collection = null, Closure $callback = null)
    {
    	$this->options = $options;
    	
        $this->value_collection = $value_collection;
    	$this->key_collection = $key_collection;

        $this->callback_option = $callback;

        return $this;
    }

    public function getOptions()
    {
    	foreach($this->options as $key => $value)
    	{
            $key = $this->_getKey($key, $value);

            $options[$key] = ($this->callback_option) ? call_user_func($this->callback_option, $value, $key) : $this->_getValue($value);
    	}

    	return $options ?? [];
    }

    private function _getKey(int | string $key, mixed $value = null): ?string
    {
        if(is_string($value))
    	{
    		return $key;
    	}

        if(is_array($value))
    	{
    		return $this->key_collection ? $value[$this->key_collection] : $key;
    	}

        if(is_a($value, Model::class))
    	{
    		return $this->key_collection ? $value->{$this->key_collection} : $value->id;
    	}

        if((new \ReflectionClass($value::class))->isEnum())
    	{
    		return $value->value;
    	}

        return null;
    }

    private function _getValue(mixed $value): ?string
    {
        if(is_string($value))
    	{
    		return $value;
    	}

        if(is_array($value))
    	{
    		return $value[$this->value_collection] ?? json_encode($value);
    	}

        if(is_a($value, Model::class))
    	{
    		return $value->{$this->value_collection} ?? $value;
    	}

        if((new \ReflectionClass($value::class))->isEnum())
    	{
    		return $value->name;
    	}

        return null;
    }
}
