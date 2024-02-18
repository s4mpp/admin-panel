<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Settings\Setting;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;
use Workbench\Database\Factories\SettingFactory;
use S4mpp\AdminPanel\Facades\Setting as SettingFacade;

class SettingTest extends TestCase
{
	public function test_get_value()
	{
		$setting_field = SettingFactory::new()->create();

		$setting_value = Setting::get($setting_field->key);

		$this->assertSame($setting_field->value, $setting_value);
	}

	public function test_get_facade()
	{
		$setting_field = SettingFactory::new()->create();

		$setting_value = SettingFacade::get($setting_field->key);

		$this->assertSame($setting_field->value, $setting_value);
	}
}