<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class Text extends Input
{
	private $mask = null;

	public function mask(string $mask)
	{
		$this->mask = $mask;

		return $this;
	}

	public function getMask()
	{
		return $this->mask;
	}

	public function renderInput(array $data)
	{
		return view('admin::input.text', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}
}