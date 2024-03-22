<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Models\Setting;

abstract class Settings
{
    public static function getRegister(string $key): ?Setting
    {
        return Setting::where('key', $key)->first();
    }

    public static function get(?string $key = null): ?string
    {
        $field = self::getRegister($key);

        return $field?->value ?? null;
    }

    // private static array $roles = [];

    // private static bool $is_activated = false;

    // public static function init(array $fields)
    // {
    // 	if(self::$is_activated)
    // 	{
    // 		return self::class;
    // 	}

    // 	self::$is_activated = true;

    // 	self::$fields = $fields;

    // 	return self::class;
    // }

    // public static function roles(...$roles)
    // {
    // 	self::$roles = $roles;

    // 	return self::class;
    // }

    // public static function isActivated()
    // {
    // 	return self::$is_activated;
    // }

    // public static function getRolesForAccess(): array
    // {
    // 	$roles = self::$roles ?? [];

    // 	if(config('admin.strict_roles', false))
    // 	{
    // 		$roles[] = 'default';
    // 	}

    // 	return $roles;
    // }
}
