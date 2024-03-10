<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Workbench\Database\Factories\UserFactory;

final class SettingsTest extends TestCase
{
    public function test_can_access_settings_page(): void
    {
        Permission::findOrCreate('Admin:settings', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('Admin:settings');

        $response = $this->actingAs($user)->get('admin/configuracoes');

        $response->assertOk();
        $response->assertSee('Configurações');
    }
}
