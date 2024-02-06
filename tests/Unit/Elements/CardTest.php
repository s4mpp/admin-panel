<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Tests\TestCase;

class CardTest extends TestCase
{
	public function test_create_card()
	{
		$card = new Card('Card title', []);

		$this->assertSame('Card title', $card->getTitle());
		$this->assertSame([], $card->getElements());
	}
}