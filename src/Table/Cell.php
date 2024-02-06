<?php

namespace S4mpp\AdminPanel\Table;

use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Column\Column;

final class Cell
{
	public function __construct(private Label $label, private mixed $value = null)
	{}

	public function getLabel()
	{
		return $this->label;
	}

	public function getValue()
	{
		return $this->value;
	}
}