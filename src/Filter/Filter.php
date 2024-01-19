<?php

namespace S4mpp\AdminPanel\Filter;

use S4mpp\AdminPanel\Traits\Titleable;

abstract class Filter
{
	use Titleable;

	function __construct(private string $title, private string $field)
	{}

	public function getField(): string
	{
		return $this->field;
	}
}