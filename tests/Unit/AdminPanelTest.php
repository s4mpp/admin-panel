<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Settings\Setting;
use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Tests\TestCase;

class AdminPanelTest extends TestCase
{
	public function test_load_resources()
	{
		$resources_loaded = AdminPanel::loadResources();

		$this->assertIsArray($resources_loaded);
		$this->assertContainsOnly(Resource::class, $resources_loaded);
	}

	public function test_get_resource()
	{
		$user_resource = AdminPanel::getResource('users');

		$this->assertInstanceOf(Resource::class, $user_resource);
	}

	public function test_get_resource_non_existent()
	{
		$non_existntent_resource = AdminPanel::getResource('xxx1231xxxxx');

		$this->assertNull($non_existntent_resource);
	}

	public function test_get_settings()
	{
		$settings = AdminPanel::getSettings();

		$this->assertInstanceOf(Settings::class, $settings);
	}
}