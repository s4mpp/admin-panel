<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use PHPUnit\Framework\Attributes\Depends;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class CustomActionTest extends TestCase
{
    public static function customActionCallbackProvider()
    {
        return [
            'run callback' => ['run-callback', 'PUT', 'Run callback'],
        ];
    }

    public static function customActionUpdateProvider()
    {
        return [
            'update' => ['update-item', 'PUT', 'Update item'],
            'update with message' => ['update-with-message', 'PUT', 'Update with message'],
        ];
    }

    public static function customActionViewProvider()
    {
        return [
            'open link' => ['view-example', 'GET', 'View example'],
        ];
    }

    public static function customActionSlideProvider()
    {
        return [
            'slide' => ['slide-example', null, 'Slide example'],
        ];
    }

    public static function customActionLinkProvider()
    {
        return [
            'link' => ['open-a-link', 'GET', 'Open a link'],
        ];
    }

    public static function customActionDangerousProvider()
    {
        return [
            'run callback danger' => ['run-callback-danger', 'PUT', 'Run callback (danger)', 'Tem certeza?'],
        ];
    }
    
    public static function customActionDisabledProvider()
    {
        return [
            'link disabled' => ['open-a-link-disabled', 'PUT', 'Open a link (disabled)',],
            'link disabled callback' => ['open-a-link-disabled-callback', 'PUT', 'Open a link (disabled callback)',],
        ];
    }

    /**
     * @dataProvider customActionCallbackProvider
     * @dataProvider customActionUpdateProvider
     * @dataProvider customActionViewProvider
     * @dataProvider customActionSlideProvider
     * @dataProvider customActionLinkProvider
     * @dataProvider customActionDangerousProvider
     * @dataProvider customActionDisabledProvider
     */
    public function test_page_read_with_custom_actions_buttons(string $slug, string $method = null, string $title): void
    {
        Permission::findOrCreate('CustomAction.action.read', 'web');
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.action.read', 'CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $response = $this->actingAs($admin)->get('painel/custom-actions/visualizar/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
    }
    
    /**
     * @dataProvider customActionDangerousProvider
     */
    public function test_page_read_with_custom_actions_danger(string $slug, string $method = null, string $title, string $message_confirmation): void
    {
        Permission::findOrCreate('CustomAction.action.read', 'web');
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.action.read', 'CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $response = $this->actingAs($admin)->get('painel/custom-actions/visualizar/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
        $response->assertSee($message_confirmation);
        $response->assertSee('modalConfirmation'.Str::ucfirst(Str::camel($slug)));
    }

    /**
     * @dataProvider customActionDisabledProvider
     */
    public function test_page_read_with_custom_actions_disabled(string $slug, string $method = null, string $title): void
    {
        Permission::findOrCreate('CustomAction.action.read', 'web');
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.action.read', 'CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $response = $this->actingAs($admin)->get('painel/custom-actions/visualizar/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
        $response->assertSee('Função não disponível no momento');
    }

    /**
     * @dataProvider customActionCallbackProvider
     */
    public function test_execute_action_callback(string $slug): void
    {
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $this->get('/painel/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->put('painel/custom-actions/acao/'.$slug.'/'.$register->id);

        $response->assertRedirect();
        $response->assertRedirectContains('/painel/custom-actions/visualizar/'.$register->id);
        $response->assertSessionHas('message');
    }

    /**
     * @dataProvider customActionUpdateProvider
     */
    public function test_execute_action_update(string $slug): void
    {
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $this->get('/painel/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->put('painel/custom-actions/acao/'.$slug.'/'.$register->id);

        $response->assertRedirect();
        $response->assertRedirectContains('/painel/custom-actions/visualizar/'.$register->id);
        $response->assertSessionHas('message');
    }

    /**
     * @dataProvider customActionViewProvider
     */
    public function test_execute_action_view(string $slug): void
    {
        Permission::findOrCreate('CustomAction.custom-action.'.$slug, 'web');
        $admin = UserFactory::new()->create()->givePermissionTo('CustomAction.custom-action.'.$slug);

        $register = CustomActionFactory::new()->create();

        $this->get('/painel/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->get('painel/custom-actions/acao/'.$slug.'/'.$register->id);

        $response->assertOk();
    }

    /**
     * @dataProvider customActionCallbackProvider
     * @dataProvider customActionUpdateProvider
     * @dataProvider customActionViewProvider
     */
    public function test_execute_action_not_logged(string $slug, string $method): void
    {
        $register = UserFactory::new()->create();

        $response = $this->{$method}('painel/custom-actions/acao/'.$slug.'/'.$register->id);

        $response->assertStatus(302);
        $response->assertRedirect('/painel/entrar');
    }
}
