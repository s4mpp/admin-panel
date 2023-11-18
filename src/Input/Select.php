<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Traits\WithSubOptions;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

final class Select extends Input
{
	use WithSubOptions;

	function __construct(
		private string $title,
		private string $name,
		array | Collection | EloquentCollection $options = [],
		string $value_collection = null,
		string $key_collection = null)
	{
		$this->options = $options;
		$this->value_collection = $value_collection;
		$this->key_collection = $key_collection;
		
		parent::__construct($title, $name);
	}

	public function renderInput()
	{
		return view('admin::input.select', ['input' => $this, 'required' => $this->isRequired()]);
	}
}