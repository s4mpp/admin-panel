<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Tests\TestCase;

final class FormSettingsTest extends TestCase
{
    public function test_save()
	{
		$component = Livewire::test(FormSettings::class, ['url' => 'url-example'])
			->set('data.text', 'teste')
			->call('save');


		$component->assertRedirect('url-example');
	}
}
