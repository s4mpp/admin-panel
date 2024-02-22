<?php

namespace S4mpp\AdminPanel\Tests\Unit\Factories;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Livewire;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;

final class CustomActionTest extends TestCase
{
    public function test_factory_link(): void
    {
        $custom_action = CustomActionFactory::link('title', 'link');

        $this->assertInstanceOf(Link::class, $custom_action);
    }

    public function test_factory_update(): void
    {
        $custom_action = CustomActionFactory::update('title', []);

        $this->assertInstanceOf(Update::class, $custom_action);
    }

    public function test_factory_callback(): void
    {
        $custom_action = CustomActionFactory::callback('title', function (): void {
        });

        $this->assertInstanceOf(Callback::class, $custom_action);
    }

    public function test_factory_livewire(): void
    {
        $custom_action = CustomActionFactory::livewire('title', 'component');

        $this->assertInstanceOf(Livewire::class, $custom_action);
    }
}
