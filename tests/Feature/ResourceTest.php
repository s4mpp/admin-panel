<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use Workbench\App\Models\BasicItem;
use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\FilterFactory;
use Workbench\Database\Factories\NumberFactory;
use Workbench\Database\Factories\BasicItemFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class ResourceTest extends TestCase
{
    public static function resourceProvider()
    {
        return [
            // 'users' => ['usuarios', 'User', 'Usuários', UserFactory::class],
            // 'custom-action' => ['custom-actions', 'CustomAction', 'Custom Actions', CustomActionFactory::class],
            // 'filters' => ['filtros', 'Filter', 'Filtros', FilterFactory::class],
            'itens-basicos' => ['itens-basicos', 'BasicItem', 'Itens básicos', BasicItemFactory::class],
            // 'numeros' => ['numeros', 'Number', 'Números', NumberFactory::class],
        ];
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_index_page(string $url, string $name, string $title): void
    {
        Permission::findOrCreate($name.':index', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.':index');

        $response = $this->actingAs($user)->get('admin/'.$url);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_create_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.':create', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.':create');
        
        $response = $this->actingAs($user)->get('admin/'.$url.'/cadastrar');

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_update_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.':update', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.':update');
        
        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get('admin/'.$url.'/editar/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_read_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.':read', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.':read');
        
        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get('admin/'.$url.'/visualizar/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_delete_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.':delete', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.':delete');
        
        $register = $factory::new()->create();

        $response = $this->actingAs($user)->delete('admin/'.$url.'/excluir/'.$register->id);

        $response->assertOk();
    }
}
