<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use PHPUnit\Framework\Attributes\Depends;
use Workbench\Database\Factories\CustomActionFactory;
use Workbench\Database\Factories\UserFactory;

final class CustomActionTest extends TestCase
{
    public static function customActionCallbackProvider()
    {
        return [
            'run callback' => ['/admin/custom-actions/acao/run-callback', 'PUT'],
        ];
    }

    public static function customActionUpdateProvider()
    {
        return [
            'update' => ['/admin/custom-actions/acao/update-item', 'PUT'],
            'update with message' => ['/admin/custom-actions/acao/update-with-message', 'PUT'],
        ];
    }

    public static function customActionViewProvider()
    {
        return [
            'open link' => ['/admin/custom-actions/acao/view-example', 'GET'],
        ];
    }

    /**
     * @dataProvider customActionCallbackProvider
     */
    public function test_execute_action_callback(string $url): void
    {
        $admin = UserFactory::new()->create();

        $register = CustomActionFactory::new()->create();

        $this->get('/admin/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->put($url.'/'.$register->id);

        $response->assertRedirect();
        $response->assertRedirectContains('/admin/custom-actions/visualizar/'.$register->id);
        $response->assertSessionHas('message');
    }

    /**
     * @dataProvider customActionUpdateProvider
     */
    public function test_execute_action_update(string $url): void
    {
        $admin = UserFactory::new()->create();

        $register = CustomActionFactory::new()->create();

        $this->get('/admin/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->put($url.'/'.$register->id);

        $response->assertRedirect();
        $response->assertRedirectContains('/admin/custom-actions/visualizar/'.$register->id);
        $response->assertSessionHas('message');
    }

    /**
     * @dataProvider customActionViewProvider
     */
    public function test_execute_action_view(string $url): void
    {
        $admin = UserFactory::new()->create();

        $register = CustomActionFactory::new()->create();

        $this->get('/admin/custom-actions/visualizar/'.$register->id);
        $response = $this->actingAs($admin)->get($url.'/'.$register->id);

        $response->assertOk();
    }

    /**
     * @dataProvider customActionCallbackProvider
     * @dataProvider customActionUpdateProvider
     * @dataProvider customActionViewProvider
     */
    public function test_execute_action_not_logged(string $url, string $method): void
    {
        $register = UserFactory::new()->create();

        $response = $this->{$method}($url.'/'.$register->id);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/signin');
    }
}
