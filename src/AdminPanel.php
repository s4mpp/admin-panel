<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Navigation\MenuItem;
use S4mpp\AdminPanel\Navigation\MenuSection;

class AdminPanel
{
	public static function getNavigation()
	{
		$route_prefix = explode('/', request()->route()->action['prefix'])[1];

		MenuSection::create('', 'main', 0);

		$sections = MenuSection::getSections();

		$dashboard = new MenuItem('Dashboard', route('dashboard_admin'), 'dashboard', 'home');
		$dashboard->setActiveOrNot($route_prefix);

		$sections['main']->add($dashboard);

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
			
			$menu_item = new MenuItem($resource->title, route($resource->getRouteName('index')), $resource->name);
			$menu_item->setActiveOrNot($route_prefix);
			
			$sections[$resource_menu_section]->add($menu_item);
		}


		return $sections;
	}
}