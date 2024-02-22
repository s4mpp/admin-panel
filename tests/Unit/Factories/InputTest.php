<?php

namespace S4mpp\AdminPanel\Tests\Unit\Factories;

use S4mpp\AdminPanel\Input\Date;
use S4mpp\AdminPanel\Input\Text;
use S4mpp\AdminPanel\Input\Email;
use S4mpp\AdminPanel\Input\Radio;
use S4mpp\AdminPanel\Input\Select;
use S4mpp\AdminPanel\Input\Checkbox;
use S4mpp\AdminPanel\Input\Textarea;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Factories\Input;

final class InputTest extends TestCase
{
    public function test_factory_text(): void
    {
        $input = Input::text('title', 'field');

        $this->assertInstanceOf(Text::class, $input);
    }

    public function test_factory_date(): void
    {
        $input = Input::date('title', 'field');

        $this->assertInstanceOf(Date::class, $input);
    }

    public function test_factory_email(): void
    {
        $input = Input::email('title', 'field');

        $this->assertInstanceOf(Email::class, $input);
    }

    public function test_factory_textarea(): void
    {
        $input = Input::textarea('title', 'field');

        $this->assertInstanceOf(Textarea::class, $input);
    }

    public function test_factory_checkbox(): void
    {
        $input = Input::checkbox('title', 'field');

        $this->assertInstanceOf(Checkbox::class, $input);
    }

    public function test_factory_radio(): void
    {
        $input = Input::radio('title', 'field');

        $this->assertInstanceOf(Radio::class, $input);
    }

    public function test_factory_select(): void
    {
        $input = Input::select('title', 'field');

        $this->assertInstanceOf(Select::class, $input);
    }
}
