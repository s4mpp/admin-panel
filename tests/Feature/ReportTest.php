<?php

namespace S4mpp\AdminPanel\Tests\Feature;

use Workbench\App\Models\BasicItem;
use S4mpp\AdminPanel\Tests\TestCase;
use Spatie\Permission\Models\Permission;
use Workbench\Database\Factories\UserFactory;

final class ReportTest extends TestCase
{
    public static function reportProvider()
    {
        return [
            'users' => ['usuarios', 'usuarios-cadastrados', 'Report'],
        ];
    }

    /**
     * @dataProvider reportProvider
     */
    public function test_report_page(string $uri_resource, string $uri, string $title): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get('admin/'.$uri_resource.'/relatorio/'.$uri);

        $response->assertOk();
        $response->assertSee($title);
    }

	/**
     * @dataProvider reportProvider
     */
    public function test_report_invalid_page(string $uri_resource, string $uri): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get('admin/usuarios/relatorio/xxxx');

        $response->assertNotFound();
    }
}
