<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait CanChangeCase
{
	private bool $uppercase = false;

	public function getIsUppercase(): bool
	{
		return $this->uppercase;
	}

	public function uppercase()
	{
		$this->uppercase = true;

		// $this->prepareForSave(function(string $value = null)
		// {
		// 	return Str::upper($value);
		// });

		return $this;
	}
}