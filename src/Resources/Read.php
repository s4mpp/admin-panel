<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Read
{
	public static function get($resource)
	{
		return function($id) use ($resource)
		{
			return $resource->getView('read', [
				'register'=> $resource->model::findOrFail($id),
				'read' => self::_getRead($resource, $id),
				'resource_actions' => $resource->getActions()
			]);
		};
	}

	private static function _getRead($resource, int $id)
	{
		throw_if(!method_exists($resource, 'getRead'), 'Método getRead não existe.');
						
		return $resource->getRead();
	}
}