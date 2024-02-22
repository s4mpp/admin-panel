<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Settings\Settings;
use Workbench\Database\Factories\SettingFactory;

final class SettingTest extends TestCase
{
    public function test_get_value(): void
    {
        $setting_field = SettingFactory::new()->create();

        $setting_value = Settings::get($setting_field->key);

        $this->assertSame($setting_field->value, $setting_value);
    }

    public function test_get_form(): void
    {
        $settings = new Settings();

        $form = $settings->getForm();

        $this->assertIsArray($form);
    }
}
