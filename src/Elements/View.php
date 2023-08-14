<?php

namespace S4mpp\AdminPanel\Elements;

class View
{
	public array $elements;

	public function elements(array $elements)
	{
		$this->elements = $elements;

		return $this;
	}

	public function getFields(): array
	{
		return $this->_findFields($this->elements, []);
	}

	private function _findFields(array $elements, array $fields_found): array
	{
		foreach($elements as $element)
		{
			if(is_a($element, Field::class))
			{
				$fields_found[] = $element;
			}
			else
			{
				return $this->_findFields($element->elements, $fields_found);
			}
		}

		return $fields_found;
	}
}