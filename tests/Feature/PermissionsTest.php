<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class PermissionsTest extends TestCase
{
    public function test_index_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get('admin/permissoes');

        $response->assertOk();
        $response->assertSee('Permissões');
	}

    public function test_generate_permissions(): void
    {
        $user = UserFactory::new()->create();

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->put('admin/permissoes/generate-permissions');

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_create_permissions(): void
    {
        $user = UserFactory::new()->create();

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->post('admin/permissoes/create-permission', [
            'permission_name' => fake()->word(),
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
    
    public function test_update_permissions(): void
    {
        $user = UserFactory::new()->create();

        $permission = Permission::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->put('admin/permissoes/update-permission/'.$permission->id, [
            'permission_name' => fake()->word(),
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_delete_permissions(): void
    {
        $user = UserFactory::new()->create();

        $permission = Permission::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->delete('admin/permissoes/delete-permission/'.$permission->id);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_create_role(): void
    {
        $user = UserFactory::new()->create();

        $permission_1 = Permission::findOrCreate('permission-1', 'web');
        $permission_2 = Permission::findOrCreate('permission-2', 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->post('admin/permissoes/create-role', [
            'role_name' => 'new-role-name',
            'permissions' => [$permission_1->name, $permission_2->name]
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
    
    public function test_update_roles(): void
    {
        $user = UserFactory::new()->create();

        $role = Role::findOrCreate(fake()->word(), 'web');

        $permission_1 = Permission::findOrCreate('permission-1', 'web');
        $permission_2 = Permission::findOrCreate('permission-2', 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->put('admin/permissoes/update-role/'.$role->id, [
            'role_name' => 'new-role-name',
            'permissions' => [$permission_1->name, $permission_2->name]
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_delete_roles(): void
    {
        $user = UserFactory::new()->create();

        $role = Role::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($user)->delete('admin/permissoes/delete-role/'.$role->id);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
}
