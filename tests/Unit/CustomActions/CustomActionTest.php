<?php

namespace S4mpp\AdminPanel\Tests\Unit\CustomActions;

use Stringable;
use Illuminate\View\View;
use Workbench\App\Models\User;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\CustomActions\Link;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\Resources\UserResource;
use Workbench\Database\Factories\UserFactory;

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
        $this->assertSame('modalConfirmationLink', $custom_action->getNameModalConfirmation());
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

    public function test_set_resource()
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $custom_action->setResource(new UserResource());

        $this->assertInstanceOf(UserResource::class, $custom_action->getResource());
    }

    public function test_set_register()
    {
        $custom_action = new Link('Link', 'https://www.example.com');

        $user = UserFactory::new()->create();
        
        $custom_action->setRegister($user);

        $this->assertInstanceOf(User::class, $custom_action->getRegister());
        $this->assertSame($user, $custom_action->getRegister());
    }

    public function test_should_open_in_new_tab(): void
    {
        $action = new Callback('Link Action', fn () => '');

        $this->assertNull($action->getTargetWindow());

        $action->newTab();

        $this->assertTrue($action->isNewTab());
        $this->assertSame('_blank', $action->getTargetWindow());
    }

    public function test_components_renders_button_link(): void
    {
        $action = new Callback('Link Action', fn () => '');

        $this->assertEquals([
            'button' => 'admin::custom-action.button.form',
            'confirmation' => 'admin::custom-action.confirmation.form',
        ], $action->getComponentName());
        
        $this->assertEquals('admin::custom-action.button.form', $action->getComponentName('button'));
        $this->assertEquals('admin::custom-action.confirmation.form', $action->getComponentName('confirmation'));
    }
}
