<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;

class PeriodTest extends TestCase
{
	public function test_create_period()
	{
		$card = new Period('Date', 'created_at');

		$this->assertSame('Date', $card->getTitle());
		$this->assertSame('created_at', $card->getField());
	}
}