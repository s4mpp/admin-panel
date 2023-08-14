<?php

namespace S4mpp\AdminPanel\Navigation;

class MenuSection
{
	private static $sections = [];

	public $items = [];

	public function __construct(public ?string $title = null, public string $identifier, public int $order)
	{}

	public function add(MenuItem $item)
	{
		$this->items[] = $item;
	}

	public static function create(string $name, string $identifier, int $order = 1)
	{
		self::$sections[] = new MenuSection($name, $identifier, $order);
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