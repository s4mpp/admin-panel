<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;
use Workbench\Database\Factories\UserFactory;

class CustomActionPagesTest extends TestCase
{
	public function customActionRoutesProvider()
	{
		return [
			'change name' => ['/admin/users/change-name', 'PUT'],
			'run callback' => ['/admin/users/run-callback', 'PUT'],
			'view example' => ['/admin/users/view-example', 'GET'],
			
		];
	}

	/**
	 * @dataProvider customActionRoutesProvider
	 */
	public function test_can_access_pages(string $url, string $method)
	{
		$user = UserFactory::new()->create();

		$response = $this->actingAs($user)->{$method}($url);

		$response->assertOk();
	}

	/**
	 * @dataProvider customActionRoutesProvider
	 */
	public function test_can_access_pages_not_logged(string $url, string $method)
	{
		$response = $this->{$method}($url);

		$response->assertStatus(302);
		$response->assertRedirect('/admin/signin');
	}
}