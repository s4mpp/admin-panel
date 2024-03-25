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
            'users' => ['usuarios', 'User', 'Usuários', UserFactory::class],
            'filters' => ['filtros', 'Filter', 'Filtros', FilterFactory::class],
            'itens-basicos' => ['itens-basicos', 'BasicItem', 'Itens básicos', BasicItemFactory::class],
            'repeaters' => ['repeaters', 'Repeater', 'Repeaters', RepeaterFactory::class],
            'reports' => ['relatorios', 'Report', 'Relatórios', ReportFactory::class],
            'numeros' => ['numeros', 'Number', 'Números', NumberFactory::class],
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
        Permission::findOrCreate($name, 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name);

        $response = $this->actingAs($user)->get('painel/'.$url);

        $response->assertOk();
        $response->assertSee($title);
        $response->assertSeeLivewire('table-resource');
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_create_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.'.action.create', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.'.action.create');
        
        $response = $this->actingAs($user)->get('painel/'.$url.'/cadastrar');

        $response->assertOk();
        $response->assertSee('Cadastrar');
        $response->assertSeeLivewire('form-resource');
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_update_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.'.action.update', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.'.action.update');
        
        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get('painel/'.$url.'/editar/'.$register->id);

        $response->assertOk();
        $response->assertSee('Editar');
        $response->assertSeeLivewire('form-resource');
    }

    /**
     * @dataProvider resourceProvider
     */
    public function test_read_page(string $url, string $name, string $title, string $factory): void
    {
        Permission::findOrCreate($name.'.action.read', 'web');

        $user = UserFactory::new()->create()->givePermissionTo($name.'.action.read');
        
        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get('painel/'.$url.'/visualizar/'.$register->id);

        $response->assertOk();
        $response->assertSee('Visualizar');
    }

    
    public function test_delete_register(): void
    {
        Permission::findOrCreate('User.action.delete', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('User.action.delete');
        
        $register = UserFactory::new()->create();

        $response = $this->actingAs($user)->delete('painel/usuarios/excluir/'.$register->id);

        $response->assertOk();
    }

    public function test_resource_without_model()
    {
        Permission::findOrCreate('EmptyWithTitle', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('EmptyWithTitle');

        $response = $this->actingAs($user)->get('painel/empty-with-error');

        $response->assertStatus(500);
    }

    public function test_resource_empty()
    {
        Permission::findOrCreate('EmptyClass', 'web');

        $user = UserFactory::new()->create()->givePermissionTo('EmptyClass');

        $response = $this->actingAs($user)->get('painel/empty');

        $response->assertStatus(200);
    }
}
