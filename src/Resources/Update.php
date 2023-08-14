<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resources\HasValidation;

abstract class Update
{
	use HasForm, HasValidation;

	public static function get($resource)
	{
		return function(int $id) use ($resource)
		{
			$register = $resource->model->findOrFail($id);

			$form = self::_getForm($resource);
			
			return $resource->getView('update', [
				'register' => $register,
				'form' => $form,
			]);
		};
	}

	public static function put($resource)
	{
		return function(int $id, Request $request) use($resource)
		{
			$form = self::_getForm($resource, $id);

			$fields = self::_getFields($form);

			self::_validate($resource, $request, $fields, $id);

			$register = $resource->model->findOrFail($id);

			foreach($fields as $field)
			{
				$register->{$field->name} = $request->{$field->name};
			}

			$register->save();

			$request->session()->flash('message', 'Alteração realizada com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}

	
}