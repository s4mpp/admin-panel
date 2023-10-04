<?php

namespace S4mpp\AdminPanel\Elements;

class Card
{
	function __construct(public $title, public array $elements)
	{}

	public static function create(string $title, array $elements)
	{
		return new Card($title, $elements);
	}

	public function render($resource)
	{
		return view('admin::elements.card', ['card' => $this, 'resource' => $resource]);
	}
}