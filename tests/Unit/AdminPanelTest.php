<?php

namespace S4mpp\AdminPanel\Tests\Unit;

use S4mpp\AdminPanel\Settings;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Tests\TestCase;
use S4mpp\AdminPanel\Resources\Resource;
use Workbench\App\AdminPanel\EmptyResource;
use S4mpp\AdminPanel\Resources\UserResource;

final class AdminPanelTest extends TestCase
{

    public function test_load_resources(): void
    {
        $resources_loaded = AdminPanel::loadResources();

        $this->assertIsArray($resources_loaded);
        $this->assertContainsOnly(Resource::class, $resources_loaded);
    }

    public function test_add_resource()
    {
        $instance = new UserResource();

        AdminPanel::addResource($instance);

        $this->assertInstanceOf(UserResource::class, AdminPanel::getResource($instance->getSlug()));
    }

    public function test_add_nullable_resource()
    {
        $instance = new EmptyResource();

        AdminPanel::addResource($instance);

        $this->assertNull(AdminPanel::getResource($instance->getSlug()));
    }

    public function test_get_resources(): void
    {
        $resources = AdminPanel::getResources();

        $this->assertIsArray($resources);
    }

    public function test_get_resource(): void
    {
        $user_resource = AdminPanel::getResource('usuarios');

        $this->assertInstanceOf(Resource::class, $user_resource);
    }

    public function test_get_resource_non_existent(): void
    {
        $non_existntent_resource = AdminPanel::getResource('xxx1231xxxxx');

        $this->assertNull($non_existntent_resource);
    }

    public function test_get_settings(): void
    {
        $settings = AdminPanel::getSettings();

        $this->assertIsArray($settings);
    }
}
