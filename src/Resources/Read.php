<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Read
{
	public static function get($resource)
	{
		return function($id) use ($resource)
		{
			// $routes = $resource->getRoutes();
			
			$register = $resource->getModel()::findOrFail($id);

			$read = self::_getRead($resource);

			foreach($read as $item)
			{
				$field = $item->getValue();
				
				if(is_callable($item->getCallback()))
				{
					if(isset($register->{$field}))
					{
						$item->setContent(call_user_func($item->getCallback(), $register->{$field}));
					}
				}
				else
				{
					$item->setContent($register->{$field});
				}
			}

			return $resource->getView('read', [
				'register'=> $register,
				// 'routes'=> $routes,
				'read' => $read,
				// 'actions' => $resource->getActions(),
				'custom_actions' => self::getCustomActions($resource, $register),
				// 'back_url' => route($routes['index']),
				// 'current_action' => 'read'
				
				'resource' => $resource
			]);
		};
	}

	private static function _getRead($resource)
	{
		throw_if(!method_exists($resource, 'getRead'), 'Método getRead não existe.');

		return $resource->getRead();
	}

	private static function getCustomActions($resource, $register)
	{
		if(!method_exists($resource, 'getCustomActions'))
		{
			return null;
		}

		foreach($resource->getCustomActions($register) ?? [] as $custom_action)
		{
			if(!$custom_action->checkPermissions())
			{
				continue;
			}

			$custom_action->setRegister($register);

			$actions[$custom_action->getSlug()] = $custom_action;
		}

		return $actions ?? [];
	}
}