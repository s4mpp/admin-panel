<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class TextTest extends TestCase
{
	public function test_create_text()
	{
		$text = new Text('Title', 'field');

		$text->mask('9999');

		$this->assertSame('9999', $text->getMask());
	}
}