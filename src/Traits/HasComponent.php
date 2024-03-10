<?php

namespace S4mpp\AdminPanel\Traits;

trait HasComponent
{
	public function getComponentName(string $key = null): ?string
    {
        if($key)
        {
            return $this->component[$key] ?? null;
        }

        return $this->component ?? null;
    }
}
