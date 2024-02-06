<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\HasMultipleOptions;

final class Checkbox extends Input
{
	use HasMultipleOptions;

	protected $view = 'admin::input.checkbox';

	// public function renderInput(array $data)
	// {
	// 	return view('admin::input.checkbox', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	// }
}