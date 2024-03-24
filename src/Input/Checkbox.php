<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasMultipleOptions;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Checkbox extends Input
{
    use HasMultipleOptions;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::input.checkbox';

    /**
     * @var int|array<int>|null
     */
    protected int|array|null $initial_value = [];

    public function processInputData(mixed $data): mixed
    {
        return json_encode($data);
    }

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.checkbox', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
