<?php

namespace S4mpp\AdminPanel\Hooks;

use Illuminate\Http\Request;

trait HasHooks
{
	public static function before($resource, $register, Request $request)
	{
		self::_call($resource, $register, 'before'.self::$action, $request);

		self::_call($resource, $register, 'beforeSave', $request);
	}

	public static function after($resource, $register, Request $request)
	{
		$has_update_hook = self::_call($resource, $register, 'after'.self::$action, $request);
		
		$has_save_hook = self::_call($resource, $register, 'afterSave', $request);

		if($has_update_hook || $has_save_hook)
		{
			$register->save();
		}
	}

	private static function _call($resource, $register, string $method, Request $request)
	{
		if(!method_exists($resource, $method))
		{
			return false;
		}
		
		$resource->{$method}($register, $request);

		return true;
	}
}