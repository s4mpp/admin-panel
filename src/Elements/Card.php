<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Elements\ElementInteface;

class Card implements ElementInteface
{
	function __construct(public $title, public array $elements)
	{}

	public static function create(string $title, array $elements)
	{
		return new Card($title, $elements);
	}

	public function render($resource)
	{
		return view('admin::form.card', ['card' => $this, 'resource' => $resource]);
	}
}