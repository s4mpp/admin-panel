<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\HasMultipleOptions;

final class Select extends Input
{
	use HasMultipleOptions;

	protected $view = 'admin::input.select';

	// public function renderInput(array $data)
	// {
	// 	return view('admin::input.select', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	// }
}