<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;
use Workbench\Database\Factories\UserFactory;

class ResourcePagesTest extends TestCase
{
	public function authRoutesProvider()
	{
		return [
			'dashboard' => ['/admin/dashboard', 'Dashboard'],
			'settings' => ['/admin/settings', 'Settings'],
			'checks' => ['/admin/checks', 'Checks'],
			'tasks' => ['/admin/tasks', 'Tasks'],
			'users' => ['/admin/users', 'Users'],
		];
	}

	/**
	 * @dataProvider authRoutesProvider
	 */
	public function test_can_access_pages(string $url, string $title)
	{
		$user = UserFactory::new()->create();

		$response = $this->actingAs($user)->get($url);

		$response->assertOk();
		$response->assertSee($title);
	}

	/**
	 * @dataProvider authRoutesProvider
	 */
	public function test_can_access_pages_not_logged(string $url)
	{

		$response = $this->get($url);

		$response->assertStatus(302);
		$response->assertRedirect('/admin/signin');
	}
}