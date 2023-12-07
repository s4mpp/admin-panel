<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\ProtectedByRoles;

abstract class Settings
{
	private static array $roles = [];

	private static $fields = [];
		
	private static bool $is_activated = false;

	public static function init(array $fields)
	{
		if(self::$is_activated)
		{
			return;
		}

		self::$is_activated = true;

		self::$fields = $fields;

		return self::class;
	}

	public static function roles(...$roles)
	{
		self::$roles = $roles;

		return self::class;
	}
	
	public static function isActivated()
	{
		return self::$is_activated;
	}
	
	public static function getForm(): array
	{
		return Utils::getOnlyOfThisOrCard(self::$fields, Input::class);
	}


	public static function getRolesForAccess(): array
	{
		$roles = self::$roles ?? [];
		
		if(config('admin.strict_roles', false))
		{
			$roles[] = 'default';
		}
		
		return $roles;
	}
}