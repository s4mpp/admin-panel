<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use Workbench\Database\Factories\UserFactory;

final class CustomActionPagesTest extends TestCase
{
    public static function customActionRoutesProvider()
    {
        return [
            'change name' => ['/admin/custom-actions/change-name', 'PUT'],
            'run callback' => ['/admin/custom-actions/run-callback', 'PUT'],
            'view example' => ['/admin/custom-actions/view-example', 'GET'],
        ];
    }

    /**
     * @dataProvider customActionRoutesProvider
     */
    public function test_can_access_pages(string $url, string $method): void
    {
        $admin = UserFactory::new()->create();

        $register = UserFactory::new()->create();

        $response = $this->actingAs($admin)->{$method}($url.'/'.$register->id);

        $response->assertOk();
    }

    /**
     * @dataProvider customActionRoutesProvider
     */
    public function test_can_access_pages_not_logged(string $url, string $method): void
    {
        $register = UserFactory::new()->create();

        $response = $this->{$method}($url.'/'.$register->id);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/signin');
    }
}
