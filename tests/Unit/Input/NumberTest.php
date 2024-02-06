<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Number;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;

class NumberTest extends TestCase
{
	public function test_create_number()
	{
		$number = new Number('Title', 'field');

		$number->step(20);
		$number->min(10);
		$number->max(40);

		$this->assertSame(20, $number->getStep());
		$this->assertSame(10, $number->getMin());
		$this->assertSame(40, $number->getMax());
	}
}