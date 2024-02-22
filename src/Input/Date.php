<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanModifyFormInput;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Date extends Input
{
    use HasValidationRules, CanModifyFormInput;

    protected string $view = 'admin::input.date';

    // public function render()
    // {
    // 	return view('admin::input.date', ['input' => $this]);
    // }
}
