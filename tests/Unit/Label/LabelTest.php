<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;

class LabelTest extends TestCase
{
	public function test_align()
	{
		$label = new Text('Title', 'field');

		$label->align('left');

		$this->assertSame('left', $label->getAlignment());
	}
}