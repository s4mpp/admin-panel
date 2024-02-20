<?php

namespace S4mpp\AdminPanel\Tests\Unit\Factories;

use S4mpp\AdminPanel\Labels\Text;
use S4mpp\AdminPanel\Labels\Badge;
use S4mpp\AdminPanel\Labels\Boolean;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Labels\Datetime;
use S4mpp\AdminPanel\Labels\LongText;
use S4mpp\AdminPanel\Labels\MarkDown;

class LabelTest extends TestCase
{
	public function test_factory_text()
	{
		$custom_action = Label::text('title', 'field');

		$this->assertInstanceOf(Text::class, $custom_action);
	}

	public function test_factory_longtext()
	{
		$custom_action = Label::longText('title', 'field');

		$this->assertInstanceOf(LongText::class, $custom_action);
	}

	public function test_factory_markdown()
	{
		$custom_action = Label::markDown('title', 'field');

		$this->assertInstanceOf(MarkDown::class, $custom_action);
	}

	public function test_factory_boolean()
	{
		$custom_action = Label::boolean('title', 'field');

		$this->assertInstanceOf(Boolean::class, $custom_action);
	}

	public function test_factory_badge()
	{
		$custom_action = Label::badge('title', 'field');

		$this->assertInstanceOf(Badge::class, $custom_action);
	}

	public function test_factory_datetime()
	{
		$custom_action = Label::datetime('title', 'field');

		$this->assertInstanceOf(Datetime::class, $custom_action);
	}

	public function test_factory_date()
	{
		$custom_action = Label::date('title', 'field');

		$this->assertInstanceOf(Datetime::class, $custom_action);
	}
}