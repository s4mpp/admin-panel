<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Index
{
	public static function get($resource)
	{
		return function() use ($resource)
		{
			$data['resource_name'] = $resource->name;
			
			if(method_exists($resource, 'getTable'))
			{
				$data['has_table'] = true;
			}
			
			return $resource->getView('index', $data ?? []);
		};
	}
}