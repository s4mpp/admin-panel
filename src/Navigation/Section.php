<?php

namespace S4mpp\AdminPanel\Navigation;

use S4mpp\AdminPanel\Navigation;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Ordenable;
use S4mpp\AdminPanel\Traits\Titleable;

final class Section
{
	use Slugable, Ordenable, Titleable;

	private $items = [];

	public function __construct(private ?string $title = null)
	{
		if($title)
		{
			$slug = $this->createSlug($title);

			throw_if(($slug == Navigation::MAIN_SECTION), '"'.Navigation::MAIN_SECTION.'" is reserved werd for sections');
		}
	}

	public function addItem(MenuItem $item)
	{
		$this->items[$item->getSlug()] = $item;
	}

	public function getItem(string $slug): ?MenuItem
	{
		return $this->items[$slug] ?? null;
	}

	public function getItems(): array
	{
		return $this->items;
	}
}