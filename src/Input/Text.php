<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\CanChangeCase;

final class Text extends Input
{
	use CanChangeCase;

	private $mask = null;

	protected $view = 'admin::input.text';

	public function mask(string $mask)
	{
		$this->mask = $mask;

		return $this;
	}

	public function getMask()
	{
		return $this->mask;
	}

	// public function render()
	// {
	// 	return view('admin::input.text', ['input' => $this]);
	// }
}