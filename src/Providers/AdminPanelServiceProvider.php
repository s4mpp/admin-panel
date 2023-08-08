<?php

namespace S4mpp\AdminPanel\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Components\Table;
use Illuminate\Support\ServiceProvider;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Commands\CreateAdmin;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\Commands\ResetPasswordAdmin;

class AdminPanelServiceProvider extends ServiceProvider 
{
    public function boot()
    {
		AboutCommand::add('AdminPanel', fn () => [
			'Guard' => config('admin.guard')
		]);

		$this->_loadResources();

		$this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

		$this->loadViewsFrom(__DIR__.'/../../views', 'admin');

		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

		Blade::component('table', Table::class, 'admin');

		if($this->app->runningInConsole())
		{
			$this->commands([
				CreateAdmin::class,
				ResetPasswordAdmin::class,
			]);

			$this->publishes([
				__DIR__.'/../../config/admin.php' => config_path('admin.php'), 
			], 'admin-config');

			$this->publishes([
				__DIR__.'/../../stubs/AdminServiceProvider.stub' => app_path('Providers/AdminServiceProvider.php'), 
			], 'admin-provider');

			$this->publishes([
				__DIR__.'/../../public/style.css' => resource_path('css/admin.css'), 
				__DIR__.'/../../public/script.ts' => resource_path('js/admin.ts'), 
			], 'admin-assets');

			$this->publishes([
				__DIR__.'/../../stubs/UserResource.stub' => app_path('AdminPanel/UserResource.php'), 
			], 'admin-user-resource');
		}
    }

	private function _loadResources()
	{
		$resources = new \FileSystemIterator(app_path('AdminPanel'));

		foreach($resources as $resource)
		{
			$resource_class_name = str_replace('.php', '', $resource->getFilename());
			$resource_name = str_replace('Resource', '', $resource_class_name);

			$class_path = '\App\AdminPanel\\'.$resource_class_name;

			$instance = new $class_path($resource_name);

			Resource::loadResource($instance);
		}
	}
}