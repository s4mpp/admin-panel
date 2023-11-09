<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Navigation\Page;
use S4mpp\AdminPanel\Module;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Navigation\MenuItem;
use S4mpp\AdminPanel\Navigation\MenuSection;

class AdminPanel
{
	private static $instance;

	private array $modules = [];

	private array $menu_sections = [];

	private function __construct()
	{}

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

	public function loadModules()
	{
		if(!empty($this->modules))
		{
			return;
		}

		$path = app_path('AdminPanel');

		if(!file_exists($path))
		{
			return;
		}

		$files = new \FileSystemIterator($path);

		foreach($files as $file)
		{
			$file_name = str_replace('.php', '', $file->getFilename());

			$class_path = '\App\AdminPanel\\'.$file_name;
			
			$resource = new $class_path();

			$this->modules[] = new Module($resource->getTitle());
		}
	}

	public function getModules(): array
	{
		return $this->modules;
	}

	public function getMenu(): array
	{
		foreach($this->modules as $module)
		{

		}

		return [];
	}




	
		














	
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
		/*$uri = request()->route()->uri();
		
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

			usort($section->items, function ($a, $b)
			{
				// Primeiro, verificamos a propriedade "order"
				if ($a->getOrder() === null && $b->getOrder() === null) {
					// Se ambos têm ordem nula, ordenamos alfabeticamente por "title"
					return strcasecmp($a->title, $b->title);
				}
				if ($a->getOrder() === null) {
					// Se apenas "a" tem ordem nula, colocamos "a" após "b"
					return 1;
				}
				if ($b->getOrder() === null) {
					// Se apenas "b" tem ordem nula, colocamos "b" após "a"
					return -1;
				}
				
				// Se ambos têm ordens definidas, ordenamos com base em "getOrder()"
				if ($a->getOrder() !== $b->getOrder()) {
					return $a->getOrder() - $b->getOrder();
				}
				
				// Se as ordens são iguais, ordenamos alfabeticamente por "title"
				return strcasecmp($a->title, $b->title);
			});
		}

		return $sections;*/

		return [];
	}
}