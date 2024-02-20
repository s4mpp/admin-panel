<?php

namespace S4mpp\AdminPanel\Tests\Unit\Factories;

use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Filter\Period;

class FilterTest extends TestCase
{
	public function test_factory_period()
	{
		$input = Filter::period('title', 'field');

		$this->assertInstanceOf(Period::class, $input);
	}
}