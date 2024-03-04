<?php

namespace S4mpp\AdminPanel\Tests\Unit\Input;

use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Tests\TestCase;

final class EmailTest extends TestCase
{
    public function test_attributes(): void
    {
		$text = new Email('Title', 'field');

		$attributes = $text->getAttributes();

		$this->assertIsArray($attributes);
		$this->assertSame(['type' => 'email'], $attributes);
	}
    
}
