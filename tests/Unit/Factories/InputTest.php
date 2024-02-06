<?php

namespace S4mpp\AdminPanel\Tests\Factories\Unit;

use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Inputs\Badge;
use S4mpp\AdminPanel\Inputs\Boolean;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Input\Checkbox;
use S4mpp\AdminPanel\Input\Date;
use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Input\Radio;
use S4mpp\AdminPanel\Input\Select;
use S4mpp\AdminPanel\Input\Textarea;
use S4mpp\AdminPanel\Inputs\Datetime;
use S4mpp\AdminPanel\Inputs\LongText;
use S4mpp\AdminPanel\Inputs\MarkDown;

class InputTest extends TestCase
{
	public function test_factory_text()
	{
		$input = Input::text('title', 'field');

		$this->assertInstanceOf(Text::class, $input);
	}

	public function test_factory_date()
	{
		$input = Input::date('title', 'field');

		$this->assertInstanceOf(Date::class, $input);
	}

	public function test_factory_email()
	{
		$input = Input::email('title', 'field');

		$this->assertInstanceOf(Email::class, $input);
	}

	public function test_factory_textarea()
	{
		$input = Input::textarea('title', 'field');

		$this->assertInstanceOf(Textarea::class, $input);
	}

	public function test_factory_checkbox()
	{
		$input = Input::checkbox('title', 'field');

		$this->assertInstanceOf(Checkbox::class, $input);
	}

	public function test_factory_radio()
	{
		$input = Input::radio('title', 'field');

		$this->assertInstanceOf(Radio::class, $input);
	}

	public function test_factory_select()
	{
		$input = Input::select('title', 'field');

		$this->assertInstanceOf(Select::class, $input);
	}
}