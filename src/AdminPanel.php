<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Navigation\MenuItem;
use S4mpp\AdminPanel\Navigation\MenuSection;

class AdminPanel
{
	public static function getNavigation()
	{
		$navigation = [
			'main' => new MenuSection()
		];

		$navigation['main']->add(new MenuItem('Dashboard', route('dashboard_admin')));

		foreach(Resource::getResources() as $resource)
		{			
			$navigation['main']->add(new MenuItem($resource->title, route($resource->getRouteName('index'))));
		}

		return $navigation;
	}
}