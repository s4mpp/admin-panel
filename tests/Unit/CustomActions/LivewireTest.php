<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Illuminate\View\View;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Livewire;

class LivewireTest extends TestCase
{
	public function test_create_livewire()
	{
		$link = new Livewire('Livewire Action', 'component-name');

		$this->assertSame('Livewire Action', $link->getTitle());
		
		$this->assertSame('slideLivewireAction', $link->getNameSlide());
	}

	public function test_render_button()
	{
		$livewire = new Livewire('Livewire Action', 'component-name');

		$this->assertInstanceOf(View::class, $livewire->renderButton());
	}
}