<?php

use Illuminate\Support\Str;
use S4mpp\Laraguard\Routes;
use S4mpp\AdminPanel\Resources\Read;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Navigation\Page;
use S4mpp\AdminPanel\Resources\Index;
use S4mpp\AdminPanel\Resources\Create;
use S4mpp\AdminPanel\Resources\Delete;
use S4mpp\AdminPanel\Resources\Update;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Controllers\AdminController;
use S4mpp\AdminPanel\Controllers\SettingsController;
use S4mpp\AdminPanel\Middleware\CustomActionEnabled;

$route = Route::middleware('web');

$prefix = config('admin.prefix', 'painel');

if($prefix)
{
	$route->prefix($prefix);
}

$route->group(function()
{
	Route::controller(AdminController::class)->group(function()
	{
		Routes::identifier('admin-panel')
		->authGroup()
		->forgotAndRecoveryPasswordGroup();
	});

	Route::redirect('/', 'entrar');

	$guard = config('admin.guard', 'web');

	Route::middleware('auth:'.$guard)->group(function()
	{
		$pages = Page::getPages();

		foreach($pages as $page)
		{
			if(!isset($page->target))
			{
				throw new \Exception('Target of Page "'.$page->slug.' "not defined');
			}

			Route::{$page->route_type}($page->slug, $page->target)->name($page->route_name);
		}

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
				
					Route::post('/cadastrar', Create::post($resource))->name($resource->getRouteName('store'));
				}

				if(in_array('read', $resource->actions))
				{
					Route::get('/visualizar/{id}', Read::get($resource))->name($resource->getRouteName('read'));
				}
		
				if(in_array('update', $resource->actions))
				{
					Route::get('/editar/{id}', Update::get($resource))->name($resource->getRouteName('update'));
				
					Route::put('/editar/{id}', Update::put($resource))->name($resource->getRouteName('save'));
				}
		
				if(in_array('delete', $resource->actions))
				{
					Route::delete('/excluir/{id}', Delete::delete($resource))->name($resource->getRouteName('delete'));
				}

				if(method_exists($resource, 'getCustomActions'))
				{
					$custom_actions = $resource->getCustomActions() ?? [];
	
					foreach($custom_actions as $action)
					{
						if(!$action->getTarget())
						{
							continue;
						}

						$is_disabled = $action->isDisabled() ? 1 : 0; 
						$message_disabled = $action->getDisabledMessage();
	
						Route::{$action->getMethod()}('/'.$action->getSlug().'/{id}', $action->getTarget() ?? '')
						->middleware('custom-action-enabled:'.$is_disabled.','.$message_disabled)
						->name($resource->getRouteName($action->getRoute()));
					}
				}
			});
		}
	});

	
	$routes_settings = Route::middleware('auth:'.$guard);
	
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