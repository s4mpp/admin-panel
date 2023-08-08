<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;

abstract class Update
{
	use HasForm;

	public static function get($resource)
	{
		return function(int $id) use ($resource)
		{
			$form = self::_getForm($resource, $id);
			
			return $resource->getView('update', [
				'form' => $form,
			]);
		};
	}

	public static function put($resource)
	{
		return function(int $id, Request $request) use($resource)
		{
			$form = self::_getForm($resource, $id);

			$item = $form->resource;

			foreach($form->fields as $field)
			{
				$item->{$field->name} = $request->{$field->name};
			}

			$item->save();

			$request->session()->flash('message', 'Alteração realizada com sucesso!');

			return redirect()->route($resource->getRouteName('index'));
		};
	}

	
}