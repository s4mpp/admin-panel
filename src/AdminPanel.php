<?php

namespace S4mpp\AdminPanel;

use SplFileInfo;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Resources\UserResource;

abstract class AdminPanel
{
    /**
     * @var array<resource>
     */
    private static $resources = [];

    /**
     * @var array<Input>
     */
    private static array $settings = [];

    /**
     * @return array<resource>
     */
    public static function loadResources(): array
    {
        $path = Config::get('admin.resources_path', app_path('AdminPanel'));

        $namespace = Config::get('admin.namespace', 'App\\');

        $filesystem = new Filesystem();

        if ($filesystem->exists($path)) {
            /**
             * @var array<SplFileInfo> $files
             */
            $files = new \FileSystemIterator($path);

            foreach ($files as $file) {
                $resource_name = $namespace.'\\AdminPanel\\'.str_replace('.php', '', $file->getFilename());
                
                /** @var Resource $resource */
                $resource = new $resource_name();

                self::addResource($resource);
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

        $slug = $resource->getSlug();

        if(array_key_exists($slug, self::$resources))
        {
            return;
        }

        self::$resources[$slug] = $resource;
    }

    public static function getResource(string $slug): ?Resource
    {
        return self::$resources[$slug] ?? null;
    }

    /**
     * @return array<resource>
     */
    public static function getResources(): array
    {
        return self::$resources;
    }

    /**
     * @param  array<Input>  $fields
     */
    public static function createSettings(array $fields = []): void
    {
        self::$settings = Finder::onlyOf($fields, Input::class, Card::class);
    }

    /**
     * @return array<Input>
     */
    public static function getSettings(): array
    {
        return self::$settings;
    }

    public static function getGuardName(): string
    {
        return config('admin.guard', 'web');
    }
}
