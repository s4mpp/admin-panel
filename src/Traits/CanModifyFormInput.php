<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;

trait CanModifyFormInput
{
    private ?Closure $prepare_for_form = null;

    // public function prepareForSave(callable $callback)
    // {
    // 	$this->prepare_for_save = $callback;

    // 	return $this;
    // }

    // public function getPrepareForSave()
    // {
    // 	return $this->prepare_for_save;
    // }

    public function prepareForForm(Closure $callback): self
    {
        $this->prepare_for_form = $callback;

        return $this;
    }

    public function getPrepareForForm(): ?Closure
    {
        return $this->prepare_for_form;
    }
}
