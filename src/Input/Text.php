<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\CanChangeCase;

final class Text extends Input
{
	use CanChangeCase;

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