<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Navigation\Page;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Navigation\MenuItem;
use S4mpp\AdminPanel\Navigation\MenuSection;

class AdminPanel
{
	private static $settings = [];

	private static $settings_roles = [];

	public static function settings(array $settings, array $settings_roles = [])
	{
		self::$settings = $settings;

		self::$settings_roles = $settings_roles;
	}

	public static function getSettings(): array
	{
		return self::$settings;
	}

	public static function getSettingsRoles(): array
	{
		return self::$settings_roles;
	}

	public static function getUserAccessSettings(): bool
	{
		if(self::$settings_roles && !Auth::guard(config('admin.guard'))->user()->hasAnyRole(self::$settings_roles))
		{
			return false;
		}

		return true;
	}

	public static function getNavigation()
	{
		$uri = request()->route()->uri();
		
		MenuSection::create('')->slug('main')->order(0);

		$sections = MenuSection::getSections();

		foreach(Resource::getResources() as $resource)
		{
			if(isset($resource->roles) && (!Auth::guard(config('admin.guard'))->user()->hasAnyRole($resource->roles)))
			{
				continue;
			}

			$resource_menu_section = $resource->section ?? 'main';

			if(!array_key_exists($resource_menu_section, $sections))
			{
				$resource_menu_section = 'main';
			}

			$route = route($resource->getRouteName('index'));
			
			$menu_item = new MenuItem($resource->title, $route, $resource->menu_order);
			$menu_item->setActiveOrNot($resource->slug, $uri);
			
			$sections[$resource_menu_section]->addItem($menu_item);
		}

		foreach(Page::getPages() as $page)
		{
			$route = route($page->route_name);

			$menu_item = new MenuItem($page->title, $route, $page->menu_order);
			$menu_item->setActiveOrNot($page->slug, $uri);

			$page_menu_section = $page->section ?? 'main';

			if(!array_key_exists($page_menu_section, $sections))
			{
				$page_menu_section = 'main';
			}
			
			$sections[$page_menu_section]->addItem($menu_item);
		}

		foreach($sections as $section)
		{
			uasort($section->items, function($a, $b)
			{
				if($a->order === null && $b->order === null)
				{
					return 0;
				}
				elseif ($a->order === null)
				{
					return 1;
				}
				elseif ($b->order === null)
				{
					return -1;
				}
				else
				{
					return ($a->order < $b->order) ? -1 : 1;
				}
		   });
			
		}

		return $sections;
	}
}