<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Traits\WithSubOptions;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

final class Checkbox extends Input
{
	use WithSubOptions;

	public function renderInput(array $data)
	{
		return view('admin::input.checkbox', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}
}