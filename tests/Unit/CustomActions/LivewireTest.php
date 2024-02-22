<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Livewire;

final class LivewireTest extends TestCase
{
    public function test_create_livewire(): void
    {
        $link = new Livewire('Livewire Action', 'component-name');

        $this->assertSame('Livewire Action', $link->getTitle());

        $this->assertSame('slideLivewireAction', $link->getNameSlide());
    }

    public function test_render_button(): void
    {
        $livewire = new Livewire('Livewire Action', 'component-name');

        $this->assertInstanceOf(View::class, $livewire->renderButton());
    }
}
