<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Livewire;

class CallbackTest extends TestCase
{
	public function test_create_callback()
	{
		$link = new Callback('Callback Action', function() {});

		$this->assertSame('Callback Action', $link->getTitle());
		
		$this->assertSame('#', $link->getUrl());
	}
}