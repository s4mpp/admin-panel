<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Checkbox extends Input
{
    use HasMultipleOptions, HasValidationRules;

    protected string $view = 'admin::input.checkbox';

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.checkbox', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
