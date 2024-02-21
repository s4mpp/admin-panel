<?php

namespace S4mpp\AdminPanel;

use Illuminate\Filesystem\Filesystem;
use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;

use function Orchestra\Testbench\workbench_path;

abstract class AdminPanel
{
    /**
     *
     * @var array<Resource>
     */
    private static $resources = [];

    private static ?Settings $settings = null;

    /**
     *
     * @return array<Resource>
     */
    public static function loadResources(): array
    {
        $path = workbench_path('app/AdminPanel');

        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {
            foreach (new \FileSystemIterator($path) as $file) {
                $class_name = '\Workbench\\App\\AdminPanel\\'.str_replace('.php', '', $file->getFilename());

                self::addResource(new $class_name());
            }

            self::addResource(new UserResource());
        }

        return self::$resources;
    }

    public static function addResource(Resource $resource): void
    {
        self::$resources[$resource->getSlug()] = $resource;
    }

    public static function getResource(string $slug): ?Resource
    {
        return self::$resources[$slug] ?? null;
    }

    /**
     *
     * @var array<Input>
     */
    public static function settings(array $fields_settings = []): void
    {
        self::$settings = new Settings($fields_settings);
    }

    public static function getSettings(): ?Settings
    {
        return self::$settings;
    }
}
