<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Elements\ElementInteface;

class Row implements ElementInteface
{
	function __construct(public array $elements)
	{}

	public static function create(array $elements)
	{
		return new Row($elements);
	}

	public function render($resource)
	{
		return view('admin::elements.row', ['row' => $this, 'resource' => $resource]);
	}
}