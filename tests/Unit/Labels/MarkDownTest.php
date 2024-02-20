<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Labels\MarkDown;

class MarkDownTest extends TestCase
{
	public function test_show_content()
	{
		$markdown = new MarkDown('Title', 'field');

		$this->assertInstanceOf(View::class, $markdown->showContent('x'));

	}
}