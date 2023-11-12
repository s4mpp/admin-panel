<?php

namespace S4mpp\AdminPanel\Crud;

abstract class Index
{
	public static function get($module)
	{
		return function() use ($module)
		{
			dump($module);

			// $routes = $resource->getRoutes();

			// $data['resource'] = $resource;

			// // $data['routes'] = $routes;
		
			// if(method_exists($resource, 'getTable'))
			// {
			// 	$data['has_table'] = true;
			// }


			// return $resource->getView('index', $data ?? []);
		};
	}
}