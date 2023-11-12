<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Resources\Resource;

trait HasResource
{
	public string $resource_name;

	private Resource $resource;

	public function setResource(string $resource_name)
	{
		$admin_panel = AdminPanel::getInstance();

		$exp = explode('\\', $resource_name); 
        
		$this->resource_name = end($exp);
 
		$this->resource = $admin_panel->getResource($this->resource_name);
	}
}
