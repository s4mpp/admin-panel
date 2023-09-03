<?php

namespace S4mpp\AdminPanel\Navigation;

use Illuminate\Support\Str;

class Page
{
	private static $pages = [];

	public $action = null;
	
	public $route_name = null;
	
	public $slug = null;
	
	public $section = null;
	
	public $route_type = 'get';

	public $menu_order = 0;

	public function __construct(public string $title)
	{
		$this->route_name = $this->slug = Str::slug($title);
	}

	public static function create(string $title)
	{
		$page = new Page($title);
 		
		self::$pages[] = $page;

		return $page;
	}

	public function target(array $target)
	{
		$this->route_type = 'get';

		$this->target = $target;

		return $this;
	}

	public function view(string $view)
	{
		$this->route_type = 'view';

		$this->target = $view;

		return $this;
	}

	public function name(string $route_name)
	{
		$this->route_name = $route_name;

		return $this;
	}
	
	public function slug(string $slug)
	{
		$this->slug = $slug;

		return $this;
	}

	public function order(string $menu_order)
	{
		$this->menu_order = $menu_order;

		return $this;
	}

	public function section(string $section)
	{
		$this->section = $section;

		return $this;
	}

	public static function getPages()
	{
		return self::$pages;
	}
}