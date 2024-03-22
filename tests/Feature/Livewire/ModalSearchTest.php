<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use Workbench\App\Models\User;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Livewire\ModalSearch;
use S4mpp\AdminPanel\Livewire\FormSettings;

final class ModalSearchTest extends TestCase
{
    public function test_search()
	{
		$component = Livewire::test(ModalSearch::class, [
			'field_name' => 'user_id',
			'model' => User::class,
			'field_to_search' => 'name',
		])
		->call('search', ['q' => 'search term']);

		$component->assertSet('search_term', 'search term');
		$component->assertDispatchedBrowserEvent('search-complete');
	}
}
