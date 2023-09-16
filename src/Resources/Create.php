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

			$routes = $resource->getRoutes();
			
			return $resource->getView('create', [
				'form' => $form,
				'routes' => $routes,
				'back_url' => route($routes['index'])
			]);
		};
	}

	public static function post($resource)
	{
		return function(Request $request) use($resource)
		{
			$form = self::_getForm($resource);

			$fields = self::_getFields($form);

			$fields_validated = self::_validate($resource, $request, $fields);

			$model = $resource->getModel();

			$new_register = new $model;

			foreach($fields as $field)
			{
				$new_register->{$field->name} = $fields_validated[$field->name];
			}

			CreateHook::before($resource, $new_register, $request);

			$new_register->save();

			CreateHook::after($resource, $new_register, $request);

			$request->session()->flash('message', 'Cadastro realizado com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}
}