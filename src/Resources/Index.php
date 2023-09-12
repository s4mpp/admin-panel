<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Index
{
	public static function get($resource)
	{
		return function() use ($resource)
		{
			$routes = $resource->getRoutes();
			
			$data['resource_name'] = $resource->name;

			$data['routes'] = $routes;

			
			if(method_exists($resource, 'getTable'))
			{
				$data['has_table'] = true;
			}

			$data['actions'] = $resource->getActions();
			// $data['custom_actions'] = $resource->getCustomActions();
			
			return $resource->getView('index', $data ?? []);
		};
	}
}