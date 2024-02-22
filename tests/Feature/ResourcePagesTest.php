<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\CustomActionFactory;

final class ResourcePagesTest extends TestCase
{
    public static function indexRoutesProvider()
    {
        return [
            'index dashboard' => ['/admin/dashboard', 'Dashboard'],
            'index settings' => ['/admin/settings', 'Settings'],
            // 'index checks' => ['/admin/checks', 'Checks'],
            // 'index tasks' => ['/admin/tasks', 'Tasks'],
            'index users' => ['/admin/users', 'Users'],
        ];
    }

    public static function createRoutesProvider()
    {
        return [
            // 'create checks' => ['/admin/checks/create', 'Checks'],
            // 'create tasks' => ['/admin/tasks/create', 'Tasks'],
            'create users' => ['/admin/users/create', 'Users'],
        ];
    }

    public static function reportRoutesProvider()
    {
        return [
            'users registered' => ['/admin/users/report/users-registered', 'Report'],
        ];
    }

    public static function updateRoutesProvider()
    {
        return [
            // 'update checks' => ['/admin/checks/update/1', 'Checks'],
            // 'update tasks' => ['/admin/tasks/update/1', 'Tasks'],
            'update users' => ['/admin/users/update', 'Users', UserFactory::class],
        ];
    }

    public static function deleteRoutesProvider()
    {
        return [
            // 'update checks' => ['/admin/checks/update/1', 'Checks'],
            // 'update tasks' => ['/admin/tasks/update/1', 'Tasks'],
            'delete users' => ['/admin/users/delete',  UserFactory::class],
        ];
    }

    public static function readRoutesProvider()
    {
        return [
            // 'read checks' => ['/admin/checks/read', 'Checks'],
            // 'read tasks' => ['/admin/tasks/read', 'Tasks'],
            'read users' => ['/admin/users/read', 'Users', UserFactory::class],
            'read custom actions' => ['/admin/custom-actions/read', 'Custom Action', CustomActionFactory::class],
        ];
    }

    public static function otherPagesProvider()
    {
        return [
            'settings' => ['/admin/settings'],
        ];
    }

    /**
     * @dataProvider indexRoutesProvider
     * @dataProvider createRoutesProvider
     * @dataProvider reportRoutesProvider
     */
    public function test_can_access_index_pages(string $url, string $title): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get($url);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider updateRoutesProvider
     */
    public function test_can_access_update_page(string $url, string $title, string $factory): void
    {
        $user = UserFactory::new()->create();

        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get($url.'/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider readRoutesProvider
     */
    public function test_can_access_read_pages(string $url, string $title, string $factory): void
    {
        $user = UserFactory::new()->create();

        $register = $factory::new()->create();

        $response = $this->actingAs($user)->get($url.'/'.$register->id);

        $response->assertOk();
        $response->assertSee($title);
    }

    /**
     * @dataProvider deleteRoutesProvider
     */
    public function test_can_access_delete_pages(string $url, string $factory): void
    {
        $user = UserFactory::new()->create();

        $register = $factory::new()->create();

        $response = $this->actingAs($user)->delete($url.'/'.$register->id);

        $response->assertOk();
    }

    /**
     * @dataProvider reportRoutesProvider
     */
    public function test_can_access_report_pages(string $url, string $factory): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get($url);

        $response->assertOk();
    }

    /**
     * @dataProvider indexRoutesProvider
     * @dataProvider otherPagesProvider
     */
    public function test_can_access_pages_not_logged(string $url): void
    {
        $response = $this->get($url);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/signin');
    }
}
