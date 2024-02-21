<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasMultipleOptions;

final class Radio extends Input
{
    use HasMultipleOptions;

    protected string $view = 'admin::input.radio';

    // public function renderInput(array $data)
    // {
    // 	return view('admin::input.radio', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
    // }
}
