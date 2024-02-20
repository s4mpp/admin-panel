<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Stringable;
use Illuminate\View\View;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Callback;

class CustomActionTest extends TestCase
{
	public function test_success_message()
	{
		$custom_action = new Link('Link', 'https://www.example.com');

		$custom_action->setSuccessMessage('Message of success');

		$this->assertInstanceOf(Stringable::class, $custom_action->getSuccessMessage());
	}

	public function test_confirm()
	{
		$custom_action = new Link('Link', 'https://www.example.com');

		$custom_action->confirm('Message of confirmation');

		$this->assertSame('Message of confirmation', $custom_action->getMessageConfirmation());
		$this->assertTrue($custom_action->hasConfirmation());
	}

	public function test_dangerous()
	{
		$custom_action = new Link('Link', 'https://www.example.com');

		$custom_action->danger();

		$this->assertTrue($custom_action->isDangerous());
	}

	public function test_disabled_boolean()
	{
		$custom_action = new Link('Link', 'https://www.example.com');

		$custom_action->disabled(true);

		$this->assertTrue($custom_action->isDisabled());
		$this->assertSame('Função não disponível no momento', $custom_action->getDisabledMessage());
	}

	public function test_disabled_callback()
	{
		$custom_action = new Link('Link', 'https://www.example.com');

		$custom_action->disabled(function() {return true;}, 'Message disabled callback');

		$this->assertTrue($custom_action->isDisabled());
		$this->assertSame('Message disabled callback', $custom_action->getDisabledMessage());
	}

	public function test_render_button_link()
	{
		$action = new Link('Link Action', '#');

		$this->assertInstanceOf(View::class, $action->renderButton());
	}

	public function test_render_button_form()
	{
		$action = new Callback('Link Action', fn() => '');

		$this->assertInstanceOf(View::class, $action->renderButton());
	}

	public function test_should_open_in_new_tab()
	{
		$action = new Callback('Link Action', fn() => '');

		$this->assertNull($action->getTargetWindow());

		$action->newTab();

		$this->assertTrue($action->isNewTab());
		$this->assertSame('_blank', $action->getTargetWindow());
	}
}