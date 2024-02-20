<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Livewire;

class ViewTest extends TestCase
{
	public function test_create_view()
	{
		$view = new View('View Action', 'view');

		$this->assertSame('View Action', $view->getTitle());
		
		$this->assertSame('#', $view->getUrl());
	}
}