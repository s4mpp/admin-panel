<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanModifyFormInput;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Date extends Input
{
    use CanModifyFormInput, HasValidationRules;

     /**
     * @return array<string>
     */
    public function getAttributes(): array
    {
        return [
            'type' => 'date'
        ];
    }

    // public function render()
    // {
    // 	return view('admin::input.date', ['input' => $this]);
    // }
}
