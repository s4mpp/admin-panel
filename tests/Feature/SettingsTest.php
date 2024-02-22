<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use Workbench\Database\Factories\UserFactory;

final class SettingsTest extends TestCase
{
    public function test_can_access_settings_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get('admin/settings');

        $response->assertOk();
        $response->assertSee('Settings');
    }
}
