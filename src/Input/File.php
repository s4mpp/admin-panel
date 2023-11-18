<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class File extends Input
{
	public function renderInput()
	{
		return view('admin::input.text', ['input' => $this, 'required' => $this->isRequired()]);
	}
}