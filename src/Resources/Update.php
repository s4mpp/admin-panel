<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Http\Request;
use S4mpp\AdminPanel\Traits\HasForm;
use S4mpp\AdminPanel\Hooks\UpdateHook;
use S4mpp\AdminPanel\Traits\HasValidation;

abstract class Update
{
	// use HasForm, HasValidation;

	public static function get($resource)
	{
		return function(int $id) use ($resource)
		{
			$register = $resource->getModel()->findOrFail($id);

			// $form = self::_getForm($resource);

			// $routes = $resource->getRoutes();
			
			return $resource->getView('update', [
				'register' => $register,
				// 'routes' => $routes,
				// 'custom_actions' => $resource->getCustomActionsResource($register),
				// 'actions' => $resource->getActions(),
				// 'repeaters' => $resource->getRepeatersResource(),
				// 'form' => $form,
				// 'back_url' => route($routes['index']),
				// 'current_action' => 'update',
				'resource' => $resource
			]);
		};
	}

	// public static function put($resource)
	// {
	// 	return function(int $id, Request $request) use($resource)
	// 	{
 	// 		$form = self::_getForm($resource, $id);

	// 		$fields = self::_getFields($form);

	// 		$fields_validated = self::_validate($request, $fields, $resource->getModel()->getTable(), $id);

	// 		$register = $resource->getModel()->findOrFail($id);

	// 		foreach($fields as $field)
	// 		{
	// 			$register->{$field->name} = $fields_validated[$field->name] ?? null;
	// 		}
		
	// 		UpdateHook::before($resource, $register, $request);
			
	// 		$register->save();
			
	// 		UpdateHook::after($resource, $register, $request);
						
	// 		$request->session()->flash('message', 'Alteração realizada com sucesso!');

	// 		return redirect()->route($resource->getRouteName('index'));
	// 	};
	// }
}