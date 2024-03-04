<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Radio extends Input
{
    use HasMultipleOptions, HasValidationRules;

    protected string $component = 'admin::input.radio';

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.radio', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
