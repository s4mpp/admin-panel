<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Navigation\Section;
use S4mpp\AdminPanel\Navigation\MenuItem;

abstract class Navigation
{
	public const MAIN_SECTION = 'main';
	
	private static $sections = [];

	public static function addSection(Section $section, string $slug = null)
	{
		$slug = ($slug) ? $slug : $section->getSlug();

		self::$sections[$slug] = $section;
	}

	public static function getSection(string $slug): ?Section
	{
		$section = self::$sections[$slug] ?? null;

		throw_if(!$section, 'Section "'.$slug.'" do not exist on Admin Panel');

		return $section;
	}

	public static function getPages(): array
	{
		foreach(self::$sections as $section)
		{
			foreach($section->getItems() as $item)
			{
				$pages[] = $item;
			}
		}

		return $pages;
	}

	public static function getMenu(): array
	{
		self::_loadResourcesOnMenu();
		
		$sections = Section::sort(self::$sections);

		self::_activateMenu($sections);

		return $sections;
	}

	private static function _loadResourcesOnMenu()
	{
		foreach(AdminPanel::getResources() as $resource)
		{
			if(!Utils::checkRoles($resource->getRolesForAccess()))
			{
				continue;
			}

			$resource_menu_section = $resource->getSection() ?? self::MAIN_SECTION;
 
			Navigation::getSection($resource_menu_section)?->addItem(
				(new MenuItem($resource->getTitle()))->route($resource->getRouteName('index'))->setOrder($resource->getMenuOrder()),
			);
		}
	}

	private static function _activateMenu(array $sections)
	{
		$current_route = request()->route()->action['as'];

		$route_path = explode('.', $current_route);

		$current_route_prefix = join('.', [$route_path[0] ?? null, $route_path[1] ?? null]);
		
		foreach($sections as $section)
		{
			foreach($section->getItems() as $item)
			{
				if(($item->getRoute() == $current_route) ||  strpos($item->getRoute(), $current_route_prefix.'.') !== false)
				{
					$item->activate();

					return;
				} 
			}
		}
	}
}