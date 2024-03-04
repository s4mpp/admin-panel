<?php

namespace S4mpp\AdminPanel\Tests;

use Illuminate\Support\Facades\Config;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithViews, WithWorkbench;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }


    protected function defineEnvironment($app): void
    {
        Config::set('database.default', 'testing');
    }
}
