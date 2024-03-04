<?php

namespace S4mpp\AdminPanel\Traits;

use Closure;
use Illuminate\Support\Str;

trait CanBeDisabled
{
    private ?bool $is_disabled = null;

    private ?Closure $disabled_callback = null;

    private ?string $disabled_message = null;

	public function disabled(bool|Closure $disabled_callback = true, ?string $disabled_message = null): self
    {
        if (is_bool($disabled_callback)) {
            $this->is_disabled = $disabled_callback;
        } elseif (is_callable($disabled_callback)) {
            $this->disabled_callback = $disabled_callback;
        }

        if ($disabled_message) {
            $this->disabled_message = $disabled_message;
        }

        return $this;
    }

    public function isDisabled(): bool
    {
        if (is_bool($this->is_disabled)) {
            return $this->is_disabled;
        }

        return (! is_null($this->disabled_callback)) ? call_user_func($this->disabled_callback, $this->register ?? null) : false;
    }

    public function getDisabledMessage(): ?string
    {
        return $this->disabled_message ?? 'Função não disponível no momento';
    }
}
