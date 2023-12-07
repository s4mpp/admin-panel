<?php

namespace S4mpp\AdminPanel;

use App\Models\Setting as SettingModel;

class Setting
{
	public static function get(string $field = null)
	{
		$setting = SettingModel::where('id', 1)->first();

		if($field)
		{
			return $setting?->{$field} ?? null;
		}

		return $setting;

	}
}