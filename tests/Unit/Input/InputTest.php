<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class InputTest extends TestCase
{
	public function test_create_instance()
	{
		$text = new Text('Title', 'field');
		
		$text->prefix('register');
		$text->description('Description of input');
		$text->prepareForForm(function() {});

		$this->assertSame('Title', $text->getTitle());
		$this->assertSame('register.field', $text->getNameWithPrefix());
		$this->assertSame('Description of input', $text->getDescription());
		$this->assertIsCallable($text->getPrepareForForm());
	}
}