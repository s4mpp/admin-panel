<?php

namespace S4mpp\AdminPanel\Traits;

trait HasComponent
{
    /**
     * @return string|array<string>|null
     */
    public function getComponentName(?string $key = null): string|array|null
    {
        if (is_array($this->component) && $key) {
            return $this->component[$key] ?? null;
        }

        return $this->component;
    }
}
