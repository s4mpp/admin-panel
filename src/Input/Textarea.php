<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Textarea extends Input
{
    use CanChangeCase, HasValidationRules;

    protected string $component = 'admin::input.textarea';

    public function __construct(string $title, string $name, private int $rows = 4)
    {
        parent::__construct($title, $name);
    }

    public function getRows(): int
    {
        return $this->rows;
    }

    /**
     * @return array<int>
     */
    public function getAttributes(): array
    {
        return [
            'rows' => $this->getRows()
        ];
    }

    // public function render()
    // {
    // 	return view('admin::input.textarea', ['input' => $this]);
    // }
}
