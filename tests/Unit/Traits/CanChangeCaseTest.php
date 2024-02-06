<?php

namespace S4mpp\AdminPanel\Tests\Unit\Traits;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Tests\TestCase;

class CanChangeCaseTest extends TestCase
{
	public static function canChangeCaseProvider()
	{
		return [
			'input text' => [new Text('title', 'field')],
		];
	}

	/**
	 *
	 * @dataProvider canChangeCaseProvider
	 */
	public function test_not_uppercase($can_change_case)
	{
		$instance = $can_change_case;

		$this->assertIsBool($instance->getIsUppercase());
		$this->assertFalse($instance->getIsUppercase());
	}

	/**
	 *
	 * @dataProvider canChangeCaseProvider
	 */
	public function test_change_to_uppercase($can_change_case)
	{
		$instance = $can_change_case;

		$instance->uppercase();

		$this->assertTrue($instance->getIsUppercase());
	}
}