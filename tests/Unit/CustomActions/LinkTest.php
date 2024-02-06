<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;

class LinkTest extends TestCase
{
	public function test_create_link()
	{
		$link = new Link('Link', 'https://www.example.com');

		$this->assertSame('Link', $link->getTitle());
		$this->assertSame('https://www.example.com', $link->getUrl());
	}
}