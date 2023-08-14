<?php

namespace S4mpp\AdminPanel\Resources;

use S4mpp\AdminPanel\Elements\Field;

trait HasForm
{
	private static function _getForm($resource, int $id = null)
	{
		throw_if(!method_exists($resource, 'getForm'), 'Método getForm não existe.');
						
		return $resource->getForm($id);
	}

	private static function _getFields(array $elements): array
	{
		return self::_findFields($elements, []);
	}

	private static function _findFields(array $elements, array $fields_found): array
	{
		foreach($elements as $element)
		{
			if(is_a($element, Field::class))
			{
				$fields_found[] = $element;
			}
			else
			{
				return self::_findFields($element->elements ?? [], $fields_found);
			}
		}

		return $fields_found;
	}
}
