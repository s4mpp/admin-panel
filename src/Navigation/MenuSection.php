<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuSection
{
	public ?string $title;
		
	public $items = [];

	public function __construct(string $title = null, array $items = [])
	{
		$this->type = 'section';

		$this->title = $title;
		
		$this->items = $items;

		return $this;
	}
}