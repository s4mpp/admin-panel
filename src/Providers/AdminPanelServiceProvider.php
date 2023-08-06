<?php

namespace S4mpp\AdminPanel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\Commands\CreateAdmin;
use S4mpp\AdminPanel\Commands\ResetPasswordAdmin;

class AdminPanelServiceProvider extends ServiceProvider 
{
    public function boot()
    {
		AboutCommand::add('AdminPanel', fn () => [
			'Guard' => config('admin.guard')
		]);

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
		}

		$this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

		$this->loadViewsFrom(__DIR__.'/../../views', 'admin');

		$this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }
}