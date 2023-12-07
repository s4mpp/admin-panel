<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\CanChangeCase;

final class Email extends Input
{
	use CanChangeCase;

	public function renderInput(array $data)
	{
		return view('admin::input.email', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}
}