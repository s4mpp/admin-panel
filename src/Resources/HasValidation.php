<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

trait HasValidation
{
	private static function _validate($resource, Request $request, array $fields, int $id = null)
	{
		$validation_rules = [];

		foreach($fields as $field)
		{
			$rules = [];
			foreach($field->rules as $rule)
			{
				switch($rule)
				{
					case 'unique':
						$rules[] = Rule::unique($resource->table)->ignore($id);
						break;
						
					default:
						$rules[] = $rule;	
				}
			}

			$validation_rules[$field->name] = $rules;
		}

		$request->validate($validation_rules);
	}
}
