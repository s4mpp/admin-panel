<?php

namespace S4mpp\AdminPanel\Form;

use S4mpp\AdminPanel\Form\FormElementInteface;

class Row implements FormElementInteface
{
	function __construct(public array $elements)
	{}

	public static function create(array $elements)
	{
		return new Row($elements);
	}

	public function render($resource)
	{
		return view('admin::form.row', ['row' => $this, 'resource' => $resource]);
	}
}