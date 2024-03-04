<?php

use App\Models\Setting;
use S4mpp\Laraguard\Routes;
use S4mpp\AdminPanel\Settings;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Navigation;
use S4mpp\AdminPanel\CustomActions\Method;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Controllers\CrudController;
use S4mpp\AdminPanel\Controllers\AdminController;
use S4mpp\AdminPanel\Controllers\SettingsController;

$route = Route::middleware('web');

$prefix = config('admin.prefix', 'painel');

if($prefix)
{
	$route->prefix($prefix);
}

/**
 * Authentication
 */
$route->group(function()
{
	Route::controller(AdminController::class)->group(function()
	{
		Routes::identifier('admin-panel')
		->authGroup(config('admin.2fa', false))
		->forgotAndRecoveryPasswordGroup();
	});

	Route::redirect('/', 'entrar');
});


/**
 * Private
 */
$route->middleware('web', 'restricted-area:'.config('admin.guard', 'web'))->group(function()
{
	/**
	 * Pages
	 */
	foreach(Navigation::getPages() as $page)
	{
		Route::get($page->getSlug(), $page->getTarget())->name($page->getRoute());
	}

	/**
	 * Resources
	 */
	foreach(AdminPanel::getResources() as $resource)
	{
		$routes_resource = Route::prefix($resource->getSlug());

		if($roles = $resource->getRolesForAccess())
		{
			$routes_resource->middleware('role:'.join('|', $roles));
		}

		$routes_resource->group(function() use ($resource)
		{
			Route::get('/', [CrudController::class, 'index'])->name($resource->getRouteName('index'));

			if($resource->hasAction('create'))
			{
				Route::get('/cadastrar', [CrudController::class, 'create'])->name($resource->getRouteName('create'));
			}

			if($resource->hasAction('read'))
			{
				Route::get('/visualizar/{id}', [CrudController::class, 'read'])->name($resource->getRouteName('read'));
			}

			if($resource->hasAction('update'))
			{
				Route::get('/editar/{id}', [CrudController::class, 'update'])->name($resource->getRouteName('update'));
			}

			if($resource->hasAction('delete'))
			{
				Route::delete('/excluir/{id}', [CrudController::class, 'delete'])->name($resource->getRouteName('delete'));
			}

			/**
			 * Custom actions
			 */
			foreach($resource->getCustomActions() as $custom_action)
			{
				if(!method_exists($custom_action, 'getCallbackRoute'))
				{
					continue;
				}

				$route_custom_action = Route::middleware('web');

				if($permissions_custom_action = $custom_action->getRolesForAccess())
				{
					$route_custom_action->middleware('role:'.join('|', $permissions_custom_action));
				}

				$route_custom_action->middleware('custom-action:'.$resource->getName().'.'.$custom_action->getSlug());

				$route_custom_action->{$custom_action->getRouteMethod()}($custom_action->getSlug().'/{id}', $custom_action->getCallbackRoute($resource))->name($custom_action->getRouteName());
			}

			/**
			 * Reports
			 */
			foreach($resource->getReports() as $report)
			{
				$route_report = Route::middleware('web');

				$route_report->get('relatorio/'.$report->getSlug(), [CrudController::class, 'report'])->name($report->getRouteName($resource->getName()));
			}
		});
	}

	/**
	 * Settings
	 */
	if(!empty(Settings::isActivated()))
	{
		$routes_settings = Route::middleware('web');

		if($settings_roles = Settings::getRolesForAccess())
		{
			$routes_settings->middleware('role:'.join('|', $settings_roles));
		}

		$routes_settings->controller(SettingsController::class)->group(function()
		{
			Route::get('configuracoes', 'settings')->name('admin.settings.index');
			Route::put('configuracoes', 'storeSettings')->name('admin.settings.store');
		});
	}
});
