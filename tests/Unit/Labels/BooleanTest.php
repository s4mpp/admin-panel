<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Labels\Boolean;
use S4mpp\AdminPanel\Tests\TestCase;

class BooleanTest extends TestCase
{
	public function test_show_content()
	{
		$boolean = new Boolean('Title', 'field');

		$this->assertInstanceOf(View::class, $boolean->showContent('x'));

	}
}