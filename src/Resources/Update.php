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

			$fields = $form->getFields();

			self::_validate($resource, $request, $fields, $id);

			$item = $form->resource;

			foreach($fields as $field)
			{
				$item->{$field->name} = $request->{$field->name};
			}

			$item->save();

			$request->session()->flash('message', 'Alteração realizada com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}

	
}