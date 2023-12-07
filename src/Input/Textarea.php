<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\CanChangeCase;

final class Textarea extends Input
{
	use CanChangeCase;

	function __construct(private string $title, private string $name, private int $rows = 4)
	{
		parent::__construct($title, $name);
	}

	public function getRows(): int
	{
		return $this->rows;
	}

	public function renderInput(array $data)
	{
		return view('admin::input.textarea', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}
}