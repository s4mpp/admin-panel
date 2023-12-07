<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Elements\Card;
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

	public static function getOnlyOf(array $items = null, $class): array
	{
		foreach($items ?? [] as $element)
		{
			if(is_subclass_of($element, $class) || is_a($element, $class))
			{
				$elements[] = $element;
			}
		}

		return $elements ?? [];
	}

	public static function getOnlyOfThisOrCard(array $items, $class): array
	{
		$elements = [];

		foreach($items as $element)
		{
			if(is_a($element, Card::class))
			{
				$elements[] = $element;

				continue;
			}
			else if(is_subclass_of($element, $class) || is_a($element, $class))
			{
				$main_card_elements[] = $element;
			}
		}

		if(isset($main_card_elements))
		{
			array_unshift($elements, new Card('', $main_card_elements));
		}

		return $elements ?? [];
	}
}