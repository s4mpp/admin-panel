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

    private Resource $resource;

    private function loadResource(): ?Resource
    {
        if (isset($this->resource)) {
            return null;
        }

        $resource = AdminPanel::getResource($this->resource_slug);
    
        if(!$resource) {
            throw new \Exception('Resource not found');
        }

        $this->setResource($resource);

        return $resource;
    }

    private function setResource(Resource $resource): Resource
    {
        $this->resource = $resource;

        return $resource;
    }
}
