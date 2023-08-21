<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

trait HasValidation
{
	private static function _validate($resource, Request $request, array $fields, int $id = null)
	{
		$validation_rules = $attributes = [];

		foreach($fields as $field)
		{
			$rules = [];
			foreach($field->rules as $rule)
			{
				switch($rule)
				{
					case 'unique':
						$rules[] = Rule::unique($resource->model->getTable())->ignore($id);
						break;
						
					default:
						$rules[] = $rule;	
				}
			}

			$validation_rules[$field->name] = $rules;

			$attributes[$field->name] = $field->title;
		}

		$validator = Validator::make($request->input(), $validation_rules, [], $attributes);

		$validator->validate();
	}
}
