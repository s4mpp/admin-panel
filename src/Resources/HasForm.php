<?php

namespace S4mpp\AdminPanel\Resources;

trait HasForm
{
	private static function _getForm($resource, int $id = null)
	{
		throw_if(!method_exists($resource, 'getForm'), 'Método getForm não existe.');
						
		return $resource->getForm($id);
	}
}
