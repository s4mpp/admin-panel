<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class TitleableTest extends TestCase
{
	public function test_get_instance_as_string()
	{
		$instance = new Text('title', 'field');

		$this->assertIsString((string) $instance);
		$this->assertIsString($instance->getTitle());
	}
}