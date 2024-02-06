<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\Table\Cell;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class CellTest extends TestCase
{
	public function test_create_cell()
	{
		$cell = new Cell(new Text('Text', 'text'), '111');

		$this->assertInstanceOf(Label::class, $cell->getLabel());
		$this->assertSame('111', $cell->getValue());
	}
}