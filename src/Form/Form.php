<?php

namespace S4mpp\AdminPanel\Form;

use Illuminate\Database\Eloquent\Model;

class Form
{
	public array $fields = [];

	function __construct(public ?Model $resource = null)
	{}

	public function fields(array $fields)
	{
		$this->fields = $fields;

		return $this;
	}
}