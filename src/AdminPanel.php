<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Resource;

abstract class AdminPanel
{
	public static function getResources(): array
	{
		$path = app_path('AdminPanel');

		if(!file_exists($path))
		{
			return [];
		}

		$resources = [];

		$files = new \FileSystemIterator($path);

		foreach($files as $file)
		{
			array_push($resources, self::getResource(str_replace('.php', '', $file->getFilename())));
		}

		return $resources;
	}

	public static function getResource(string $resource_name): Resource
	{
		$class_path = '\App\AdminPanel\\'.$resource_name;

		return new $class_path($resource_name);
	}
}