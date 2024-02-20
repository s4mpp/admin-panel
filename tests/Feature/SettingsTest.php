<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;
use Workbench\Database\Factories\CustomActionFactory;
use Workbench\Database\Factories\UserFactory;

class SettingsTest extends TestCase
{
	public function test_can_access_settings_page()
	{
		$user = UserFactory::new()->create();

		$response = $this->actingAs($user)->get('admin/settings');

		$response->assertOk();
		$response->assertSee('Settings');
	}
}