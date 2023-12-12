<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Traits\Titleable;

final class Card
{
	use Titleable;

	function __construct(private string $title, private array $elements)
	{}

	public function getElements(): array
	{
		return $this->elements;
	}

	public function render($data, $register = null)
	{
		return view('admin::elements.card', ['card' => $this, 'data' => $data, 'register' => $register]);
	}
}