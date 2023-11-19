<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Resource;

trait WithAdminResource
{
	public string $resource_name;

	private ?Resource $resource = null;

	private function _setResource(string $resource_name)
	{ 
		if($this->resource)
		{
			return;
		}

		$this->resource = AdminPanel::getResource($resource_name.'Resource');

		$this->resource_name = $resource_name;
	}
}