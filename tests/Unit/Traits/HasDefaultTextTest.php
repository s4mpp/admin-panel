<?php

namespace S4mpp\AdminPanel\Tests\Unit\Traits;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class HasDefaultTextTest extends TestCase
{
	public static function hasDefaultTextTestProvider()
	{
		return [
			'input text' => [new Text('Title', 'field')],
		];
	}

	/**
	 *
	 * @dataProvider hasDefaultTextTestProvider
	 */
	public function test_not_has_default_text($has_default_text)
	{
		$instance = $has_default_text;

		$this->assertNull($instance->getDefaultText());
	}

	/**
	 *
	 * @dataProvider hasDefaultTextTestProvider
	 */
	public function test_has_default_text($has_default_text)
	{
		$instance = $has_default_text;

		$instance->default('Default text');

		$this->assertSame('Default text', $instance->getDefaultText());
	}
}