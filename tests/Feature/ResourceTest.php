<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use Exception;
use Workbench\App\Models\BasicItem;
use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Workbench\Database\Factories\DateFactory;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\FilterFactory;
use Workbench\Database\Factories\NumberFactory;
use Workbench\Database\Factories\ReportFactory;
use Workbench\Database\Factories\SelectFactory;
use Workbench\Database\Factories\RepeaterFactory;
use Workbench\Database\Factories\BasicItemFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class ResourceTest extends TestCase
{
    public static function resourceProvider()
    {
        return [
            // 'numeros' => ['numeros', 'Number', 'Números', NumberFactory::class],
            
            'users' => ['usuarios', 'User', 'Usuários', UserFactory::class],
            'filters' => ['filtros', 'Filter', 'Filtros', FilterFactory::class],
            'itens-basicos' => ['itens-basicos', 'BasicItem', 'Itens básicos', BasicItemFactory::class],
            'repeaters' => ['repeaters', 'Repeater', 'Repeaters', RepeaterFactory::class],
            'reports' => ['relatorios', 'Report', 'Relatórios', ReportFactory::class],
            'selects' => ['selects', 'Select', 'Selects', SelectFactory::class],
            'custom-action' => ['custom-actions', 'CustomAction', 'Custom Actions', CustomActionFactory::class],
            'dates' => ['datas', 'Date', 'Datas', DateFactory::class],
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
        $response->assertSeeLivewire('table-resource');
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
        $response->assertSee('Cadastrar');
        $response->assertSeeLivewire('form-resource');
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
        $response->assertSee('Editar');
        $response->assertSeeLivewire('form-resource');
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
        $response->assertSee('Visualizar');
    }

    
    public function test_delete_register(): void
    {
        Permission::findOrCreate('User:delete', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('User:delete');
        
        $register = UserFactory::new()->create();

        $response = $this->actingAs($user)->delete('admin/usuarios/excluir/'.$register->id);

        $response->assertOk();
    }

    public function test_resource_without_model()
    {
        Permission::findOrCreate('EmptyWithTitle:index', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('EmptyWithTitle:index');

        $response = $this->actingAs($user)->get('admin/empty-with-error');

        $response->assertStatus(500);
    }

    public function test_resource_empty()
    {
        Permission::findOrCreate('EmptyClass:index', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('EmptyClass:index');

        $response = $this->actingAs($user)->get('admin/empty');

        $response->assertStatus(200);
    }
}
