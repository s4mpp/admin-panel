<?php

namespace S4mpp\AdminPanel;

abstract class Settings
{
	private static $fields = [];
	
	private static $settings_roles = [];
	
	private static bool $is_activated = false;

	public static function init(array $fields)
	{
		if(self::$is_activated)
		{
			return;
		}

		self::$is_activated = true;

		self::$fields = $fields;
	}

	public static function isActivated()
	{
		return self::$is_activated;
	}
	
	public static function getForm(): array
	{
		return self::$fields;
	}

	public static function getRolesForAccess(): array
	{
		return self::$settings_roles;
	}
}