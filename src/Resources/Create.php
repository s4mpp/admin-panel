<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
use S4mpp\AdminPanel\Hooks\CreateHook;
use S4mpp\AdminPanel\Resources\HasValidation;

abstract class Create
{
	use HasForm, HasValidation;

	public static function get($resource)
	{
		return function() use ($resource)
		{
			$form = self::_getForm($resource);
			
			return $resource->getView('create', [
				'form' => $form,
			]);
		};
	}

	public static function post($resource)
	{
		return function(Request $request) use($resource)
		{
			$form = self::_getForm($resource);

			$fields = self::_getFields($form);

			self::_validate($resource, $request, $fields);

			$new_register = new $resource->model;

			foreach($fields as $field)
			{
				$new_register->{$field->name} = $request->{$field->name};
			}

			CreateHook::before($resource, $new_register);

			$new_register->save();

			CreateHook::after($resource, $new_register);

			$request->session()->flash('message', 'Cadastro realizado com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}
}