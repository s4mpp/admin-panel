<?php

namespace S4mpp\AdminPanel\Navigation;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Traits\HasSlug;

final class Section
{
	use HasSlug;

	private $items = [];

	public function __construct(private ?string $title = null)
	{
		if($title)
		{
			$slug = $this->createSlug($title);

			throw_if(($slug == AdminPanel::MAIN_SECTION), '"'.AdminPanel::MAIN_SECTION.'" is reserved werd for sections');
		}
	}

	public function addItem(MenuItem $item)
	{
		$this->items[$item->getSlug()] = $item;
	}

	public function getItems(): array
	{
		return $this->items;
	}

	public function getTitle(): ?string
	{
		return $this->title;
	}

	/*private static $sections = [];

	public $items = [];

	public $slug = null;
	
	public $order = 1;

	public function __construct(public ?string $title = null)
	{
		$this->slug = Str::slug($title);
	}

	public function addItem(MenuItem $item)
	{
		$this->items[] = $item;
	}

	public function slug($slug)
	{
		$this->slug = $slug;
		
		return $this;
	}

	public function order($order)
	{
		$this->order = $order;

		return $this;
	}

	public static function create(string $name)
	{
		$section = new MenuSection($name);
		
		self::$sections[] = $section;

		return $section;
	}

	public static function getSections(): array
	{
		$sections = [];

		usort(self::$sections, function ($a, $b)
		{
			if($a->order == $b->order)
			{
				return 0;
			}
			
			return ($a->order < $b->order) ? -1 : 1;
		});

		foreach(self::$sections as $section)
		{
			$sections[$section->slug] = $section;
		}

		return $sections;
	}*/

}