<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use Workbench\App\Models\User;
use Spatie\Permission\Models\Role;
use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class PermissionsTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        Permission::findOrCreate('Admin:permissions', 'web');

        $this->user = UserFactory::new()->create()->givePermissionTo('Admin:permissions');
    }

    public function test_index_page(): void
    {
        $response = $this->actingAs($this->user)->get('admin/permissoes');

        $response->assertOk();
        $response->assertSee('Permissões');
	}

    public function test_generate_permissions(): void
    {
		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->put('admin/permissoes/generate-permissions');

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_create_permissions(): void
    {
		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->post('admin/permissoes/create-permission', [
            'permission_name' => fake()->word(),
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
    
    public function test_update_permissions(): void
    {
        $permission = Permission::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->put('admin/permissoes/update-permission/'.$permission->id, [
            'permission_name' => fake()->word(),
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_delete_permissions(): void
    {
        $permission = Permission::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->delete('admin/permissoes/delete-permission/'.$permission->id);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_create_role(): void
    {
        $permission_1 = Permission::findOrCreate('permission-1', 'web');
        $permission_2 = Permission::findOrCreate('permission-2', 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->post('admin/permissoes/create-role', [
            'role_name' => 'new-role-name',
            'permissions' => [$permission_1->name, $permission_2->name]
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
    
    public function test_update_roles(): void
    {
        $role = Role::findOrCreate(fake()->word(), 'web');

        $permission_1 = Permission::findOrCreate('permission-1', 'web');
        $permission_2 = Permission::findOrCreate('permission-2', 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->put('admin/permissoes/update-role/'.$role->id, [
            'role_name' => 'new-role-name',
            'permissions' => [$permission_1->name, $permission_2->name]
        ]);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}

    public function test_delete_roles(): void
    {
        $role = Role::findOrCreate(fake()->word(), 'web');

		$this->get('admin/permissoes');
        $response = $this->actingAs($this->user)->delete('admin/permissoes/delete-role/'.$role->id);

        $response->assertRedirect();
        $response->assertRedirectContains('admin/permissoes');
	}
}
