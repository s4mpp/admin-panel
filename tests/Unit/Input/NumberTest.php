<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use S4mpp\AdminPanel\Input\Number;
use S4mpp\AdminPanel\Tests\TestCase;

final class NumberTest extends TestCase
{
    public function test_step()
    {
        $number = new Number('Title', 'field');

        $number->step(20);

        $this->assertSame(20, $number->getStep());
    }

    public function test_min()
    {
        $number = new Number('Title', 'field');

        $number->min(20);

        $this->assertSame(20, $number->getMin());
    }

    public function test_max()
    {
        $number = new Number('Title', 'field');

        $number->max(20);

        $this->assertSame(20, $number->getMax());
    }

    public function test_attributes(): void
    {
		$number = new Number('Title', 'field');

		$attributes = $number->getAttributes();

		$this->assertIsArray($attributes);
		// $this->assertSame(['type' => 'number', 'min' => 0, 'max' => Number::MAX_NUMBER, 'step' => null], $attributes);
	}
}
