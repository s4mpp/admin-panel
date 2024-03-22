<?php

namespace S4mpp\AdminPanel\Tests\Feature\Livewire;

use Livewire\Livewire;
use S4mpp\AdminPanel\Livewire\FormResource;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Tests\TestCase;

final class FormResourceTest extends TestCase
{
	public function test_render()
	{
		$url_to_redirect_after_save = route('lg.web.usuarios.index');

		$component = Livewire::test(FormResource::class, [
			'resource_slug' => 'usuarios',
			'url_to_redirect_after_save' => $url_to_redirect_after_save
		]);

		$component->assertSee('Salvar');
	}

    public function test_save()
	{
		$url_to_redirect_after_save = route('lg.web.usuarios.index');

		$component = Livewire::test(FormResource::class, [
			'resource_slug' => 'usuarios',
			'url_to_redirect_after_save' => $url_to_redirect_after_save
		])
		->set('data.name', 'Name')
		->set('data.email', 'user@email.com')
		->set('data.password', '12345678')
		->call('save');

		$component->assertRedirect($url_to_redirect_after_save);
	}
}
