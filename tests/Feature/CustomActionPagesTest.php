<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;
use Workbench\Database\Factories\UserFactory;

class CustomActionPagesTest extends TestCase
{
	public static function customActionRoutesProvider()
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
		$admin = UserFactory::new()->create();

		$register = UserFactory::new()->create();

		$response = $this->actingAs($admin)->{$method}($url.'/'.$register->id);

		$response->assertOk();
	}

	/**
	 * @dataProvider customActionRoutesProvider
	 */
	public function test_can_access_pages_not_logged(string $url, string $method)
	{
		$register = UserFactory::new()->create();

		$response = $this->{$method}($url.'/'.$register->id);

		$response->assertStatus(302);
		$response->assertRedirect('/admin/signin');
	}
}