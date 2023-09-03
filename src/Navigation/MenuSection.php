<?php

namespace S4mpp\AdminPanel\Navigation;

use Illuminate\Support\Str;

class MenuSection
{
	private static $sections = [];

	public $items = [];

	public $identifier = null;
	
	public $order = 1;

	public function __construct(public ?string $title = null)
	{
		$this->identifier = Str::slug($title);
	}

	public function addItem(MenuItem $item)
	{
		$this->items[] = $item;
	}

	public function identifier($identifier)
	{
		$this->identifier = $identifier;
		
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
			$sections[$section->identifier] = $section;
		}

		return $sections;
	}

}