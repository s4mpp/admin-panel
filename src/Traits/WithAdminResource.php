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

    private function loadResource(): ?Resource
    {
        if ($this->resource) {
            return null;
        }

        return $this->setResource(AdminPanel::getResource($this->resource_slug));
    }

    private function setResource(Resource $resource): Resource
    {
        $this->resource = $resource;

        return $resource;
    }
}
