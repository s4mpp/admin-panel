<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use S4mpp\AdminPanel\Input\Date;
use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Tests\TestCase;

final class DateTest extends TestCase
{
    public function test_attributes(): void
    {
		$date = new Date('Title', 'field');

		$attributes = $date->getAttributes();

		$this->assertIsArray($attributes);
		$this->assertSame(['type' => 'date'], $attributes);
	}
    
}
