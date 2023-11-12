<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Navigation\Section;
use S4mpp\AdminPanel\Navigation\MenuItem;

final class Navigation
{
	private static $instance;

	private $sections = [];

	private function __construct()
	{
		$this->sections['main'] = new Section();
	}

	private function __clone()
	{}

	public static function getInstance()
	{
		if(self::$instance === null)
		{
			self::$instance = new self;
		}
		
		return self::$instance;
	}

	public function addSection(Section $section)
	{
		$this->sections[$section->getSlug()] = $section;
	}

	public function getSection(string $slug): ?Section
	{
		$section = $this->sections[$slug] ?? null;

		throw_if(!$section, 'Section "'.$slug.'" do not exist on Admin Panel');

		return $section;
	}

	public function getSections()
	{
		return $this->sections;
	}

	public function getPages(): array
	{
		foreach($this->sections as $section)
		{
			foreach($section->getItems() as $item)
			{
				$pages[] = $item;
			}
		}

		return $pages;
	}

	public function getMenu(): array
	{
		$admin_panel = AdminPanel::getInstance();

		$navigation = Navigation::getInstance();

		$current_route = request()->route()->action['as'];

		foreach($admin_panel->getResources() as $resource)
		{
			// if(isset($resource->roles) && (!Auth::guard(config('admin.guard'))->user()->hasAnyRole($resource->roles)))
			// {
			// 	continue;
			// }

			$resource_menu_section = $resource->getSection() ?? $admin_panel::MAIN_SECTION;

			// if(!array_key_exists($resource_menu_section, $sections))
			// {
			// 	$resource_menu_section = 'main';
			// }

			// $route = route($resource->getRouteName('index'));
			
			// $menu_item = new MenuItem($resource->title, $route, $resource->menu_order);
			// $menu_item->setActiveOrNot($resource->slug, $uri);

 
			$navigation->getSection($resource_menu_section)?->addItem(
				(new MenuItem($resource->getTitle()))->route($resource->getRouteName('index')),
			);
		}
		
		$sections = $navigation->getSections();

		foreach($sections as $section)
		{
			foreach($section->getItems() as $item)
			{				
				if(strpos($current_route, str_replace('.index', '', $item->getRoute())) !== false)
				{
					$item->activate();
				} 
			}
		}

		return $sections;
	}
	
}