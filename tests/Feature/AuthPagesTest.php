<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use S4mpp\AdminPanel\Tests\TestCase;

final class AuthPagesTest extends TestCase
{
    public static function authRoutesProvider()
    {
        return [
            'signin' => ['/admin/signin', 'Sign In'],
            'password recovery' => ['/admin/password-recovery', 'Password recovery'],
        ];
    }

    /**
     * @dataProvider authRoutesProvider
     */
    public function test_can_access_pages(string $url, string $title): void
    {
        $response = $this->get($url);

        $response->assertOk();
        $response->assertSee($title);
    }

    public function test_do_not_can_access_page_register(): void
    {
        $response = $this->get('/admin/signup');

        $response->assertNotFound();
    }
}
