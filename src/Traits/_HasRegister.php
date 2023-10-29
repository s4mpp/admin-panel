<?php

namespace S4mpp\AdminPanel\Traits;

trait HasRegister
{
	private $register;

	public function setRegister($register)
	{
		$this->register = $register;

		return $this;
	}

	public function getRegister()
	{
		return $this->register;
	}
}