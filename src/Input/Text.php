<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\CanChangeCase;
use S4mpp\AdminPanel\Traits\CanModifyFormInput;
use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Text extends Input
{
    use CanChangeCase, CanModifyFormInput, HasValidationRules;

    private ?string $mask = null;

    protected string $view = 'admin::input.text';

    public function mask(string $mask): self
    {
        $this->mask = $mask;

        return $this;
    }

    public function getMask(): ?string
    {
        return $this->mask;
    }

    // public function render()
    // {
    // 	return view('admin::input.text', ['input' => $this]);
    // }
}
