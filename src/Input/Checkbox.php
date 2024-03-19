<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Checkbox extends Input
{
    use HasMultipleOptions, HasValidationRules;

    /**
     *
     * @var string|array<string>
     */
    protected string|array $component = 'admin::input.checkbox';

    protected $initial_value = [];

    public function processInputData($data): null|int|string
    {
        return json_encode($data);
    }

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.checkbox', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
