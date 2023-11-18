<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class Text extends Input
{
	public function renderInput(array $data)
	{
		return view('admin::input.text', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}
}