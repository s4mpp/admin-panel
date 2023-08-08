<?php

namespace S4mpp\AdminPanel\Form;

class Field
{
	public string $type = 'text';
	
	public array $rules = ['required', 'string'];

	function __construct(public $title, public $name)
	{}

	public static function create(string $title, string $name)
	{
		return new Field($title, $name);
	}

	public function email()
	{
		$this->type = 'email';

		$this->rules = array_merge($this->rules, ['email', 'unique']);
		
		return $this;
	}

	// public function datetime(string $format)
	// {
	// 	$this->callback(function($item) use ($format)
	// 	{
	// 		return $item->format($format);
	// 	});

	// 	return $this;
	// }

	// public function callback(callable $callback)
	// {
	// 	$this->callback = $callback;
	// }

	// public function align(string $alignment)
	// {
	// 	$this->style_class[] = 'text-'.$alignment;
		
	// 	return $this;
	// }

	// public function strong()
	// {
	// 	$this->style_class[] = 'text-strong';
		
	// 	return $this;
	// }
}