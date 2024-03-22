<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use S4mpp\AdminPanel\Livewire\FormRepeater;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Tests\TestCase;

final class FormRepeaterTest extends TestCase
{
    public function test_set_register()
	{
		$component = Livewire::test(FormRepeater::class, [
			'resource_slug' => 'repeaters',
			'repeater_slug' =>'child-repeaters',
		])
		->call('setRegister', 1, 2, ['title' => 'new-title']);

		$component->assertSet('id_temp', 1);
		$component->assertSet('register_id', 2);
		$component->assertSet('data', ['title' => 'new-title']);
	}

    public function test_save()
	{
		$component = Livewire::test(FormRepeater::class, [
			'resource_slug' => 'repeaters',
			'repeater_slug' =>'child-repeaters',
		])
		->call('save');

		$component->assertDispatchedBrowserEvent('close-slide');

		$component->assertEmittedTo('form-resource', 'setChild');

		$component->assertSet('id_temp', null);
		$component->assertSet('register_id', null);
		$component->assertSet('data', []);
	}
}
