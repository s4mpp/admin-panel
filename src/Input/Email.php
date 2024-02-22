<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Email extends Input
{
    use CanChangeCase, HasValidationRules;

    protected string $view = 'admin::input.email';

    // public function render()
    // {
    // 	return view('admin::input.email', ['input' => $this]);
    // }
}
