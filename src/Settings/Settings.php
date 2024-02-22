<?php

namespace S4mpp\AdminPanel\Settings;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Models\Setting;

final class Settings
{
    /**
     * @param  array<Input>  $fields
     */
    public function __construct(private array $fields = [])
    {
    }

    /**
     * @return array<Input|Card>
     */
    public function getForm(): array
    {
        return Finder::onlyOf($this->fields, Input::class, Card::class);
    }

    public static function get(?string $key = null): ?string
    {
        $field = Setting::query()->where('key', $key)->first();

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
