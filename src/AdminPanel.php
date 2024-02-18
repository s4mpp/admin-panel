<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Resources\Resource;

use S4mpp\AdminPanel\Resources\UserResource;
use function Orchestra\Testbench\workbench_path;

abstract class AdminPanel
{
	private static $resources = [];

	private static ?Settings $settings = null;

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
}