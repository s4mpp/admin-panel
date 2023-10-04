<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Traits\HasLabel;

class ItemView
{
	use HasLabel;
 		
	function __construct(public $title, public $value)
	{}

	public static function create(string $title, string $name)
	{
		return new ItemView($title, $name);
	}

	public function render($resource = null)
	{
		return view('admin::elements.item-view', ['item' => $this, 'resource' => $resource]);
	}
}