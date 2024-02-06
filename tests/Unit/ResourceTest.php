<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;

class ResourceTest extends TestCase
{
	public function test_create_instance()
	{
		$resource = new UserResource();

		$this->assertEquals('User', $resource->getName());
		$this->assertEquals('users', $resource->getSlug());
		$this->assertEquals('Users', $resource->getTitle());
	}
}