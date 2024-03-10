<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Stringable;
use Illuminate\View\View;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Update;

final class CustomActionTest extends TestCase
{
    public function test_success_message(): void
    {
        $custom_action = new Update('Link', []);

        $custom_action->setSuccessMessage('Message of success');

        $this->assertSame('Message of success', trim($custom_action->getSuccessMessage()));
    }

    public function test_confirm(): void
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $custom_action->confirm('Message of confirmation');

        $this->assertSame('Message of confirmation', $custom_action->getMessageConfirmation());
        $this->assertTrue($custom_action->hasConfirmation());
    }

    public function test_dangerous(): void
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $custom_action->danger();

        $this->assertTrue($custom_action->isDangerous());
    }

    public function test_disabled_boolean(): void
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $custom_action->disabled(true);

        $this->assertTrue($custom_action->isDisabled());
        $this->assertSame('Função não disponível no momento', $custom_action->getDisabledMessage());
    }

    public function test_disabled_callback(): void
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $custom_action->disabled(fn () => true, 'Message disabled callback');

        $this->assertTrue($custom_action->isDisabled());
        $this->assertSame('Message disabled callback', $custom_action->getDisabledMessage());
    }

    // public function test_render_button_link(): void
    // {
    //     $action = new Link('Link Action', '#');

    //     $this->assertInstanceOf(View::class, $action->renderButton());
    // }
    
    // public function test_render_button_disabled(): void
    // {
    //     $action = new Link('Link Action', '#');

    //     $this->assertInstanceOf(View::class, $action->renderButtonDisabled());
    // }

    // public function test_render_button_form(): void
    // {
    //     $action = new Callback('Link Action', fn () => '');

    //     $this->assertInstanceOf(View::class, $action->renderButton());
    // }

    // public function test_render_modal_confirmation(): void
    // {
    //     $action = new Callback('Link Action', fn () => '');

    //     $this->assertInstanceOf(View::class, $action->renderContentModalConfirmation());
    // }

    public function test_should_open_in_new_tab(): void
    {
        $action = new Callback('Link Action', fn () => '');

        $this->assertNull($action->getTargetWindow());

        $action->newTab();

        $this->assertTrue($action->isNewTab());
        $this->assertSame('_blank', $action->getTargetWindow());
    }
}
