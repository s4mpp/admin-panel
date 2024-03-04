<?php

namespace S4mpp\AdminPanel;

use SplFileInfo;
use S4mpp\AdminPanel\Input\Input;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use S4mpp\AdminPanel\Settings\Settings;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;

abstract class AdminPanel
{
    /**
     * @var array<resource>
     */
    private static $resources = [];

    private static ?Settings $settings = null;

    /**
     * @return array<resource>
     */
    public static function loadResources(): array
    {
        $path = Config::get('admin.path', app_path('AdminPanel'));

        $namespace = Config::get('admin.namespace', 'App\\AdminPanel');

        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {

            /**
             * @var array<SplFileInfo> $files
             */
            $files = new \FileSystemIterator($path);

            foreach ($files as $file) {

                $class_name = $namespace.'\\'.str_replace('.php', '', $file->getFilename());

                self::addResource(new $class_name());
            }

        }

        self::addResource(new UserResource());

        return self::$resources;
    }

    public static function addResource(Resource $resource): void
    {
        $title = $resource->getTitle();

        if (! $title) {
            return;
        }

        self::$resources[$resource->getSlug()] = $resource;
    }

    public static function getResource(string $slug): ?Resource
    {
        return self::$resources[$slug] ?? null;
    }

    /**
     * @return array<Resource>
     */
    public static function getResources(): array
    {
        return self::$resources;
    }

    /**
     * @param  array<Input> $fields_settings
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
