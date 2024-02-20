<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Labels\Badge;
use S4mpp\AdminPanel\Tests\TestCase;

class BadgeTest extends TestCase
{
	public function test_show_content()
	{
		$badge = new Badge('Title', 'field');

		$this->assertInstanceOf(View::class, $badge->showContent('x'));

	}
}