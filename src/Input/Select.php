<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Select extends Input
{
    use HasMultipleOptions, CanChangeCase, HasValidationRules;

    protected string $view = 'admin::input.select';

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.select', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
