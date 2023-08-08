<?php

namespace S4mpp\AdminPanel\Resources;

abstract class Read
{
	public static function get($resource)
	{
		return function($id) use ($resource)
		{
			return $resource->getView('read', [
				'resource'=> $resource->model::findOrFail($id)
			]);
		};
	}
}