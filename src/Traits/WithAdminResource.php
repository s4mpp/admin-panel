<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Resources\Resource;

/**
 * @codeCoverageIgnore
 */
trait WithAdminResource
{
    public string $resource_slug;

    private ?Resource $resource = null;

    private function loadResource(): void
    {
        if ($this->resource) {
            return;
        }

        $this->resource = AdminPanel::getResource($this->resource_slug);
    }
}
