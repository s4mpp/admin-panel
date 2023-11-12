<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Traits\HasDefaultText;
use S4mpp\AdminPanel\Traits\HasLabel;

class ItemView
{
	use HasLabel, HasDefaultText;
 		
	function __construct(private string $title, private ?string $value)
	{}

	public static function create(string $title, string $name)
	{
		return new ItemView($title, $name);
	}

	public function render($register = null)
	{
		return view('admin::elements.item-view', ['item' => $this, 'register' => $register]);
	}

	public function getValue(): ?string
	{
		return $this->value;
	}

	public function getTitle(): string
	{
		return $this->title;
	}
}