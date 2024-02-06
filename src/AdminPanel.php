<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Resources\Resource;

use S4mpp\AdminPanel\Resources\UserResource;
use function Orchestra\Testbench\workbench_path;

abstract class AdminPanel
{
	private static $resources = [];

	private static $settings = null;

	public static function loadResources()
	{
		$path = workbench_path('app/AdminPanel');

		foreach(new \FileSystemIterator($path) as $file)
		{
			$class_name = '\App\AdminPanel\\'.str_replace('.php', '', $file->getFilename());

			self::addResource(new $class_name());
		}

		self::addResource(new UserResource());

		return self::$resources;
	}

	public static function addResource(Resource $resource)
	{
		self::$resources[$resource->getSlug()] = $resource;
	}

	public static function getResource(string $slug): ?Resource
	{
		return self::$resources[$slug] ?? null;
	}

	public static function settings(array $fields_settings = [])
	{
		self::$settings = new Settings($fields_settings);
	}

	public static function getSettings(): ?Settings
	{
		return self::$settings;
	}
	
	// public static function getResources(): array
	// {
	// 	$path = app_path('AdminPanel');

	// 	if(!file_exists($path))
	// 	{
	// 		return [];
	// 	}

	// 	$resources = [];

	// 	$files = new \FileSystemIterator($path);

	// 	foreach($files as $file)
	// 	{
	// 		array_push($resources, self::getResource(str_replace('.php', '', $file->getFilename())));
	// 	}

	// 	return $resources;
	// }

	// public static function getResource(string $resource_name): Resource
	// {
	// 	$class_path = '\App\AdminPanel\\'.$resource_name;

	// 	return new $class_path($resource_name);
	// }
}