<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Read
{
	public static function get($resource)
	{
		return function($id) use ($resource)
		{
			$register = $resource->getModel()::findOrFail($id);

			$routes = $resource->getRoutes();

			return $resource->getView('read', [
				'register'=> $register,
				'routes'=> $routes,
				'read' => self::_getRead($resource, $id),
				'actions' => $resource->getActions(),
				'custom_actions' => $resource->getCustomActionsResource($register),
				'back_url' => route($routes['index']),
				'current_action' => 'read'
			]);
		};
	}

	private static function _getRead($resource, int $id)
	{
		throw_if(!method_exists($resource, 'getRead'), 'Método getRead não existe.');
						
		return $resource->getRead();
	}
}