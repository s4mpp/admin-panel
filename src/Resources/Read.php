<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Read
{
	public static function get($resource)
	{
		return function($id) use ($resource)
		{
			$routes = $resource->getRoutes();
			
			$register = $resource->getModel()::findOrFail($id);

			$read = self::_getRead($resource);

			foreach($read as $item)
			{
				if($item->callback)
				{
					$field = $item->value;

					if(isset($register->{$field}))
					{
						$register->{$field} = call_user_func($item->callback, $register->{$field});
					}
				}
			}

			return $resource->getView('read', [
				'register'=> $register,
				'routes'=> $routes,
				'read' => $read,
				'actions' => $resource->getActions(),
				'custom_actions' => $resource->getCustomActionsResource($register),
				'back_url' => route($routes['index']),
				'current_action' => 'read'
			]);
		};
	}

	private static function _getRead($resource)
	{
		throw_if(!method_exists($resource, 'getRead'), 'Método getRead não existe.');

		return $resource->getRead();
	}
}