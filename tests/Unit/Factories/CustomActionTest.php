<?php

namespace S4mpp\AdminPanel\Tests\Factories\Unit;

use Illuminate\Mail\Markdown;
use S4mpp\AdminPanel\Labels\Badge;
use S4mpp\AdminPanel\Labels\Boolean;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Labels\Datetime;
use S4mpp\AdminPanel\Labels\LongText;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Livewire;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\CustomAction as CustomActionFactory;
use S4mpp\AdminPanel\Labels\Text;

class CustomActionTest extends TestCase
{
	public function test_factory_link()
	{
		$custom_action = CustomActionFactory::link('title', 'link');

		$this->assertInstanceOf(Link::class, $custom_action);
	}

	public function test_factory_update()
	{
		$custom_action = CustomActionFactory::update('title', []);

		$this->assertInstanceOf(Update::class, $custom_action);
	}

	public function test_factory_callback()
	{
		$custom_action = CustomActionFactory::callback('title', function(){});

		$this->assertInstanceOf(Callback::class, $custom_action);
	}

	public function test_factory_livewire()
	{
		$custom_action = CustomActionFactory::livewire('title', 'component');

		$this->assertInstanceOf(Livewire::class, $custom_action);
	}
}