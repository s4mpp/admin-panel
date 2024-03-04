<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait CanBeDangerous
{
    private ?string $message_confirmation = null;

    private bool $has_confirmation = false;

    private bool $is_danger = false;

    public function confirm(string $message_confirmation = 'Tem certeza?'): self
    {
        $this->message_confirmation = $message_confirmation;

        $this->has_confirmation = true;

        return $this;
    }

    public function getMessageConfirmation(): ?string
    {
        return $this->message_confirmation;
    }

    public function hasConfirmation(): bool
    {
        return $this->has_confirmation;
    }

    public function danger(): self
    {
        $this->is_danger = true;

        if (! $this->has_confirmation) {
            $this->confirm();
        }

        return $this;
    }

    public function isDangerous(): bool
    {
        return $this->is_danger;
    }
}
