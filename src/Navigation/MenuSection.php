<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuSection
{
	public ?string $title;
		
	public $items = [];

	public function __construct(string $title = null)
	{
		$this->title = $title;

		return $this;
	}

	public function add(MenuItem $item)
	{
		$this->items[] = $item;
	}
}