<?php

namespace S4mpp\AdminPanel\Settings;

use S4mpp\AdminPanel\Models\Setting as SettingModel;

class Setting
{
	public static function get(string $key = null)
	{
		$field = SettingModel::query()->where('key', $key)->first();

		return $field?->value ?? null;
	}
}