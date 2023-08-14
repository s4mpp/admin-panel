<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Index
{
	public static function get($resource)
	{
		return function() use ($resource)
		{
			$data = [];

			if(method_exists($resource, 'getTable'))
			{
				$data['table'] = $resource->getTable();
				
				$data['data_table'] = $resource->model::paginate();

				$data['resource_actions'] = $resource->getActions();
			}
			
			return $resource->getView('index', $data);
		};
	}
}