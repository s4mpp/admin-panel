<?php

namespace S4mpp\AdminPanel\Tests\Unit\Labels;

use Illuminate\View\View;
use S4mpp\AdminPanel\Labels\File;
use S4mpp\AdminPanel\Tests\TestCase;

class FileTest extends TestCase
{
	public function test_show_content()
	{
		$file = new File('Title', 'field');

		$this->assertInstanceOf(View::class, $file->showContent('x'));

	}
}