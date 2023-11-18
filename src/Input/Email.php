<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class Email extends Input
{
	public function renderInput()
	{
		return view('admin::input.email', ['input' => $this, 'required' => $this->isRequired()]);
	}
}