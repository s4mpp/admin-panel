<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Select extends Input
{
    use CanChangeCase, HasMultipleOptions;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::input.select';

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.select', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
