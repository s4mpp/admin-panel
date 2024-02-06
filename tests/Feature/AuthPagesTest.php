<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\Laraguard\Laraguard;

class AuthPagesTest extends TestCase
{
	public function authRoutesProvider()
	{
		return [
			'signin' => ['/admin/signin', 'Sign In'],
			// 'password recovery' => ['/admin/password-recovery', 'Password Recovery']
		];
	}

	/**
	 * @dataProvider authRoutesProvider
	 */
	public function test_can_access_pages(string $url, string $title)
	{
		$response = $this->get($url);

		$response->assertOk();
		$response->assertSee($title);
	}
}