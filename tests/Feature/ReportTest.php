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
            ['listagem-de-registros', 'Listagem de registros'],
            ['cadastros-por-data', 'Cadastros por data'],
        ];
    }

    /**
     * @dataProvider reportProvider
     */
    public function test_report_page(string $slug, string $title): void
    {
        Permission::findOrCreate('Report.report.'.$slug, 'web');

        $user = UserFactory::new()->create()->givePermissionTo('Report.report.'.$slug);

        $response = $this->actingAs($user)->get('painel/relatorios/relatorio/'.$slug);

        $response->assertOk();
        $response->assertSee($title);
    }


    public function test_report_invalid_page(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->get('painel/relatorios/relatorio/xxxx');

        $response->assertNotFound();
    }
}
