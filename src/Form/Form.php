<?php

namespace S4mpp\AdminPanel\Form;

use S4mpp\AdminPanel\Form\Row;
use Illuminate\Database\Eloquent\Model;

class Form
{
	public array $elements;

	function __construct(public ?Model $resource = null)
	{}

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