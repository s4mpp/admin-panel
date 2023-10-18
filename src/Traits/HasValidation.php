<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\ValidatedInput;
use Illuminate\Support\Facades\Validator;

trait HasValidation
{
	private static function _validate(Request $request, array $fields, string $table, int $id = null): ValidatedInput
	{
		$validation_rules = $attributes = [];

		$input = $request->input();

		foreach($fields as $field)
		{
			if($field->getPrepareForValidation())
			{
				$input[$field->name] = call_user_func($field->getPrepareForValidation(), $input[$field->name]);
			}

			$rules = [];
			foreach($field->getRules() as $rule)
			{
				switch($rule)
				{
					case 'unique':
						$rules[] = Rule::unique($table)->ignore($id);
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
