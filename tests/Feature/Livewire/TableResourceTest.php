<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Livewire\FormRepeater;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\TableResource;
use Workbench\Database\Factories\UserFactory;
use Workbench\Database\Factories\RelationshipFactory;

final class TableResourceTest extends TestCase
{
	public static function resourceProvider(): array
	{
		return [
			'users' => ['usuarios', UserFactory::class],
			'relationships' => ['relacionamentos', RelationshipFactory::class],
		];
	}

	/**
	 * @dataProvider resourceProvider
	 */
	public function test_render_empty_table(string $slug, $factory)
	{
		$component = Livewire::test(TableResource::class, [
			'resource_slug' => $slug,
		]);

		$component->assertSee('No content');
	}

	/**
	 * @dataProvider resourceProvider
	 */
	public function test_render_registers(string $slug, $factory)
	{
		$factory::new()->count(10)->create();

		$component = Livewire::test(TableResource::class, [
			'resource_slug' => $slug,
		]);

		$component->assertSee('10 registros');
	}

	/**
	 * @dataProvider resourceProvider
	 */
    public function test_search(string $slug, $factory)
	{
		$component = Livewire::test(TableResource::class, [
			'resource_slug' => $slug,
		])
		->call('search', ['q' => 'search term']);

		$component->assertSet('search_term', 'search term');
		$component->assertDispatchedBrowserEvent('search-complete');
	}

	/**
	 * @dataProvider resourceProvider
	 */
	public function test_filter(string $slug, $factory)
	{
		$component = Livewire::test(TableResource::class, [
			'resource_slug' => $slug,
		])
		->call('filter', ['created_at' => ['start' => '2024-01-01', 'end' => '2024-01-02']]);

		$component->assertSet('filters', ['created_at' => ['start' => '2024-01-01', 'end' => '2024-01-02']]);
		$component->assertDispatchedBrowserEvent('filter-complete');
	}
}
