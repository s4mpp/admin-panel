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
				$table = $resource->getTable();
				
				$data = $resource->model::orderBy($resource->ordenation[0] ?? 'id', $resource->ordenation[1] ?? 'DESC')->paginate();

				$data = [
					'table' => $table,
					'data_table' => $data,
					'resource_actions' => $resource->getActions()
				];
			}
			
			return $resource->getView('index', $data);
		};
	}
}