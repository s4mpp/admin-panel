<?php

namespace S4mpp\AdminPanel\Hooks;

trait HasHooks
{
	public static function before($resource, $register)
	{
		self::_call($resource, $register, 'before'.self::$action);

		self::_call($resource, $register, 'beforeSave');
	}

	public static function after($resource, $register)
	{
		$has_update_hook = self::_call($resource, $register, 'after'.self::$action);
		
		$has_save_hook = self::_call($resource, $register, 'afterSave');

		if($has_update_hook || $has_save_hook)
		{
			$register->save();
		}
	}

	private static function _call($resource, $register, string $method)
	{
		if(!method_exists($resource, $method))
		{
			return false;
		}
		
		$resource->{$method}($register);

		return true;
	}
}