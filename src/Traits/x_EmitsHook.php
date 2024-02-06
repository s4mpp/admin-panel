<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\ValidatedInput;

trait EmitsHook
{
	// public static function before($resource, $register, ValidatedInput $fields_validated)
	// {
	// 	self::_call($resource, $register, 'before'.self::$action, $fields_validated);

	// 	self::_call($resource, $register, 'beforeSave', $fields_validated);
	// }

	// public static function after($resource, $register, ValidatedInput $fields_validated)
	// {
	// 	$has_update_hook = self::_call($resource, $register, 'after'.self::$action, $fields_validated);
		
	// 	$has_save_hook = self::_call($resource, $register, 'afterSave', $fields_validated);

	// 	if($has_update_hook || $has_save_hook)
	// 	{
	// 		$register->save();
	// 	}
	// }

	// private static function _call($resource, $register, string $method, ValidatedInput $fields_validated)
	// {
	// 	if(!method_exists($resource, $method))
	// 	{
	// 		return false;
	// 	}
		
	// 	$resource->{$method}($register, $fields_validated);

	// 	return true;
	// }
}


// $resource->hook('beforeUpdate')
// $resource->hook('beforeCreate')
// $resource->hook('beforeSave')

// $resource->hook('afterUpdate')
// $resource->hook('afterCreate')
// $resource->hook('afterSave')