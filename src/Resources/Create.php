<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
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

			self::_validate($resource, $request, $form->fields);

			$new_resource = new $resource->model;

			foreach($form->fields as $field)
			{
				$new_resource->{$field->name} = $request->{$field->name};
			}

			$new_resource->save();

			$request->session()->flash('message', 'Cadastro realizado com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}
}