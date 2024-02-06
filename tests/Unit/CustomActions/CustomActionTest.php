<?php

namespace S4mpp\AdminPanel\Tests\Unit\Elements;

use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Tests\TestCase;
use Stringable;

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
}