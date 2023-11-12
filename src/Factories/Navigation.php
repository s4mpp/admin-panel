<?php

namespace S4mpp\AdminPanel\Factories;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Navigation as AdminPanelNavigation;
use S4mpp\AdminPanel\Navigation\Section;
use S4mpp\AdminPanel\Navigation\MenuItem;

abstract class Navigation
{
	public static function section(string $title): Section
	{
		$navigation = AdminPanelNavigation::getInstance();

		$section = new Section($title);

		$navigation->addSection($section);

		return $section;
	}

	public static function item(string $title, string $section = AdminPanel::MAIN_SECTION): MenuItem
	{
		$navigation = AdminPanelNavigation::getInstance();

		$item = new MenuItem($title);
		
		$navigation->getSection($section)?->addItem($item);

		return $item;
	}
}