<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\ReportResult;
use S4mpp\AdminPanel\Tests\TestCase;

final class ReportResultTest extends TestCase
{
    public function test_filter()
	{
		$component = Livewire::test(ReportResult::class, [
			'resource_slug' => 'relatorios',
			'report_slug' => 'listagem-de-registros',
		])
		->call('filter', ['created_at' => ['start' => '2024-01-01', 'end' => '2024-01-02']]);

		$component->assertSet('filters', ['created_at' => ['start' => '2024-01-01', 'end' => '2024-01-02']]);
		$component->assertDispatched('filter-complete');
	}
}
