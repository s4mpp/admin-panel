<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Facades\Auth;

abstract class Utils
{	
	public static function checkRoles(array $roles)
	{
		if(empty($roles))
		{
			return true;
		}

		return Auth::guard(config('admin.guard', 'web'))->user()->hasAnyRole($roles);
	}

	public static function checkPermissions(array $permissions)
	{
		if(empty($permissions))
		{
			return true;
		}

		return Auth::guard(config('admin.guard', 'web'))->user()->can($permissions);
	}
}