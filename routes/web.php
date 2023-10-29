<?php

use Illuminate\Support\Str;
use S4mpp\Laraguard\Routes;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Actions\View;
use S4mpp\AdminPanel\Actions\Method;
use S4mpp\AdminPanel\Resources\Read;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Navigation\Page;
use S4mpp\AdminPanel\Resources\Index;
use S4mpp\AdminPanel\Actions\Callback;
use S4mpp\AdminPanel\Actions\Prompt;
use S4mpp\AdminPanel\Resources\Create;
use S4mpp\AdminPanel\Resources\Delete;
use S4mpp\AdminPanel\Resources\Update;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Controllers\AdminController;
use S4mpp\AdminPanel\Actions\Update as UpdateAction;
use S4mpp\AdminPanel\Controllers\SettingsController;
use S4mpp\AdminPanel\Middleware\CustomActionEnabled;
use S4mpp\AdminPanel\Controllers\CustomActionController;

$route = Route::middleware('web');

$guard = config('admin.guard', 'web');

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
		->authGroup()
		->forgotAndRecoveryPasswordGroup();
	});

	Route::redirect('/', 'entrar');
});


/**
 * Private
 */
$route->middleware('web', 'auth:'.$guard)->group(function() use ($guard)
{
	/**
	 * Pages
	 */
	$pages = Page::getPages();

	foreach($pages as $page)
	{
		if(!isset($page->target))
		{
			throw new \Exception('Target of Page "'.$page->slug.' "not defined');
		}

		Route::{$page->route_type}($page->slug, $page->target)->name($page->route_name);
	}
	
	/**
	 * Resources
	 */
	$resources = Resource::getResources();

	foreach($resources as $resource)
	{
		$routes_resource = Route::prefix($resource->slug);
		
		if(isset($resource->roles))
		{
			$routes_resource->middleware('role:'.join('|', ($resource->roles ?? [])));
		}
		
		$routes_resource->group(function() use ($resource)
		{
			Route::get('/', Index::get($resource))->name($resource->getRouteName('index'));
	
			if(in_array('create', $resource->actions))
			{
				Route::get('/cadastrar', Create::get($resource))->name($resource->getRouteName('create'));
			
				// Route::post('/cadastrar', Create::post($resource))->name($resource->getRouteName('store'));
			}

			if(in_array('read', $resource->actions))
			{
				Route::get('/visualizar/{id}', Read::get($resource))->name($resource->getRouteName('read'));
			}
	
			if(in_array('update', $resource->actions))
			{
				Route::get('/editar/{id}', Update::get($resource))->name($resource->getRouteName('update'));
			
				// Route::put('/editar/{id}', Update::put($resource))->name($resource->getRouteName('save'));
			}
	
			if(in_array('delete', $resource->actions))
			{
				Route::delete('/excluir/{id}', Delete::delete($resource))->name($resource->getRouteName('delete'));
			}

			if(method_exists($resource, 'getCustomActions'))
			{
				$custom_actions = $resource->getCustomActions() ?? [];

				foreach($custom_actions as $custom_action)
				{
					if(method_exists($custom_action, 'getCallbackRoute'))
					{
						$route_custom_action = Route::middleware('web');

						if($permissions_custom_action = $custom_action->getPermissions())
						{
							$route_custom_action->middleware('can:'.join('|', $permissions_custom_action));
						}

						$route_custom_action->{$custom_action->getRouteMethod()}($custom_action->getSlug().'/{id}', $custom_action->getCallbackRoute($resource))->name($custom_action->getRouteName());
					}
				}
			}
		});
	}
	

	/**
	 * Settings
	 */
	$routes_settings = Route::middleware('web');
	
	$settings_roles = AdminPanel::getSettingsRoles();
	
	if(!empty($settings_roles))
	{
		$routes_settings->middleware('role:'.join('|', ($settings_roles ?? [])));
	}

	$routes_settings->controller(SettingsController::class)->group(function()
	{
		Route::get('configuracoes', 'settings')->name('admin_settings');
		Route::put('configuracoes', 'storeSettings')->name('store_settings');
	});
});