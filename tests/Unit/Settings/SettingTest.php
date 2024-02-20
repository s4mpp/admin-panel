<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Settings\Setting;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;
use Workbench\Database\Factories\SettingFactory;
use S4mpp\AdminPanel\Facades\Setting as SettingFacade;
use S4mpp\AdminPanel\Settings\Settings;

class SettingTest extends TestCase
{
	public function test_get_value()
	{
		$setting_field = SettingFactory::new()->create();

		$setting_value = Settings::get($setting_field->key);

		$this->assertSame($setting_field->value, $setting_value);
	}

	public function test_get_form()
	{
		$settings = new Settings();

		$form = $settings->getForm();

		$this->assertIsArray($form);
	}
}