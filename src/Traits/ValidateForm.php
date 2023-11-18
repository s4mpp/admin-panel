<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Facades\Validator;

trait ValidateForm
{
	private function _validate($data, array $fields, int $register_id = null)
	{
		$validation_rules = $attributes = [];

		foreach($fields as $field)
		{
			if($field->getPrepareForValidation())
			{
				$data[$field->getName()] = call_user_func($field->getPrepareForValidation(), $data[$field->getName()]);
			}

			$validation_rules[$field->getName()] = $field->getRules($register_id);

			$attributes[$field->getName()] = $field->getTitle();
		}

		$validator = Validator::make($data, $validation_rules, [], $attributes);

		$validator->validate();

		return $validator->safe();
	}
}
