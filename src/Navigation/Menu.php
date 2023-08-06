<?php

namespace S4mpp\AdminPanel\Navigation;

class Menu
{
	private static $navigations = [];

	public static function sidebar(array $items)
	{
		self::$navigations['sidebar'] = $items;
	}

	public static function add($item)
	{
		return $item;
	}

	public static function getNavigations()
	{
		return self::$navigations;
	}
}