<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Index
{
	public static function get($resource)
	{
		return function() use ($resource)
		{
			if(method_exists($resource, 'getIndex'))
			{
				$data = [
					'list'=> $resource->getIndex()
				];
			}
			
			return $resource->getView('index', $data ?? []);
		};
	}
}