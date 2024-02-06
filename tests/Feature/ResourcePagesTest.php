<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;
use Workbench\Database\Factories\UserFactory;

class ResourcePagesTest extends TestCase
{
	public static function indexRoutesProvider()
	{
		return [
			'index dashboard' => ['/admin/dashboard', 'Dashboard'],
			'index settings' => ['/admin/settings', 'Settings'],
			'index checks' => ['/admin/checks', 'Checks'],
			'index tasks' => ['/admin/tasks', 'Tasks'],
			'index users' => ['/admin/users', 'Users'],
		];
	}

	public static function createRoutesProvider()
	{
		return [
			'create checks' => ['/admin/checks/create', 'Checks'],
			'create tasks' => ['/admin/tasks/create', 'Tasks'],
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
		];
	}

	/**
	 * @dataProvider indexRoutesProvider
	 * @dataProvider createRoutesProvider
	 * @dataProvider reportRoutesProvider
	 */
	public function test_can_access_index_pages(string $url, string $title)
	{
		$user = UserFactory::new()->create();

		$response = $this->actingAs($user)->get($url);

		$response->assertOk();
		$response->assertSee($title);
	}

	/**
	 * @dataProvider readRoutesProvider
	 * @dataProvider updateRoutesProvider
	 */
	public function test_can_access_register_pages(string $url, string $title, string $factory)
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
	public function test_can_access_delete_pages(string $url, string $factory)
	{
		$user = UserFactory::new()->create();

		$register = $factory::new()->create();

		$response = $this->actingAs($user)->delete($url.'/'.$register->id);

		$response->assertOk();
	}

	/**
	 * @dataProvider indexRoutesProvider
	 */
	public function test_can_access_pages_not_logged(string $url)
	{

		$response = $this->get($url);

		$response->assertStatus(302);
		$response->assertRedirect('/admin/signin');
	}
}