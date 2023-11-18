<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\Navigation\Section;
use S4mpp\AdminPanel\Navigation\MenuItem;
use S4mpp\AdminPanel\Navigation as AdminPanelNavigation;

abstract class Navigation
{
	public static function section(string $title, string $slug = null): Section
	{
		$section = new Section($title);

		AdminPanelNavigation::addSection($section, $slug);

		return $section;
	}

	public static function item(string $title, string $section = AdminPanelNavigation::MAIN_SECTION): MenuItem
	{
		if($section == AdminPanelNavigation::MAIN_SECTION && !isset(self::$sections[AdminPanelNavigation::MAIN_SECTION]))
		{
			AdminPanelNavigation::addSection((new Section())->setOrder(0), AdminPanelNavigation::MAIN_SECTION);
		}

		$item = new MenuItem($title);
		
		AdminPanelNavigation::getSection($section)->addItem($item);

		return $item;
	}
}