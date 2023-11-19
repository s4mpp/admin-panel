<?php

namespace S4mpp\AdminPanel\Providers;

use Livewire\Livewire;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Components\Table;
use Illuminate\Support\ServiceProvider;
use S4mpp\AdminPanel\Commands\CreateAdmin;
use S4mpp\AdminPanel\Livewire\FormResource;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\TableResource;
use S4mpp\AdminPanel\Middleware\CustomAction;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\Commands\ResetPasswordAdmin;

class AdminPanelServiceProvider extends ServiceProvider 
{
    public function boot()
    {		
		$this->loadRoutesFrom(__DIR__.'/../../routes/web.php');

		$this->loadViewsFrom(__DIR__.'/../../views', 'admin');

		$this->loadMigrationsFrom(__DIR__.'/../../migrations');

		Livewire::component('table-resource', TableResource::class);
		Livewire::component('form-resource', FormResource::class);
		Livewire::component('form-settings', FormSettings::class);
 
		Blade::component('table', Table::class);
			
		Paginator::defaultView('admin::pagination');

		app('router')->aliasMiddleware('custom-action', CustomAction::class);

		if($this->app->runningInConsole())
		{
			AboutCommand::add('AdminPanel', fn () => [
				'Guard' => config('admin.guard')
			]);

			$this->commands([
				CreateAdmin::class,
				ResetPasswordAdmin::class
			]);

			$this->publishes([
				__DIR__.'/../../config/config.stub' => config_path('admin.php'), 
			], 'admin-config');

			$this->publishes([
				__DIR__.'/../../stubs/AdminServiceProvider.stub' => app_path('Providers/AdminServiceProvider.php'), 
			], 'admin-provider');

			$this->publishes([
				__DIR__.'/../../stubs/UserResource.stub' => app_path('AdminPanel/UserResource.php'), 
			], 'admin-user-resource');

			$this->publishes([
				__DIR__.'/../../stubs/migration_create_settings_table.stub' => database_path('migrations/'.date('Y_m_d_His').'_create_settings_table.php'), 
				__DIR__.'/../../stubs/ModelSetting.stub' => app_path('Models/Setting.php'), 
			], 'admin-settings');
		}
    }
}