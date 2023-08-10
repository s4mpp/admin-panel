<?php

namespace S4mpp\AdminPanel\Form;

use S4mpp\AdminPanel\Form\Row;
use Illuminate\Database\Eloquent\Model;

class Form
{
	public array $elements;

	function __construct(public ?Model $resource = null)
	{}

	public function elements(array $elements)
	{
		$this->elements = $elements;

		return $this;
	}
}