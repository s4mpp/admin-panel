<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;

class AdminPanelTest extends TestCase
{
	public function test_load_resources()
	{
		$resources_loaded = AdminPanel::loadResources();

		$this->assertIsArray($resources_loaded);
	}

	public function test_add_resource()
	{

	}

	public function test_get_resource()
	{

	}

	public function test_add_settings()
	{

	}

	public function test_get_settings()
	{

	}
}