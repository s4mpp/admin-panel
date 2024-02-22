<?php

namespace S4mpp\AdminPanel\Traits;

trait Strongable
{
    private bool $strong = false;

    public function strong(): self
    {
        $this->strong = true;

        return $this;
    }

    public function getIsStrong(): bool
    {
        return $this->strong;
    }
}
