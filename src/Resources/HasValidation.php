<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\ValidatedInput;
use Illuminate\Support\Facades\Validator;

trait HasValidation
{
	private static function _validate($resource, Request $request, array $fields, int $id = null): ValidatedInput
	{
		$validation_rules = $attributes = [];

		$input = $request->input();

		foreach($fields as $field)
		{
			if($field->prepare_for_validation)
			{
				$input[$field->name] = call_user_func($field->prepare_for_validation, $input[$field->name]);
			}

			$rules = [];
			foreach($field->rules as $rule)
			{
				switch($rule)
				{
					case 'unique':
						$rules[] = Rule::unique($resource->getModel()->getTable())->ignore($id);
						break;
						
					default:
						$rules[] = $rule;	
				}
			}

			$validation_rules[$field->name] = $rules;

			$attributes[$field->name] = $field->title;
		}

		$validator = Validator::make($input, $validation_rules, [], $attributes);

		$validator->validate();

		return $validator->safe();
	}
}
