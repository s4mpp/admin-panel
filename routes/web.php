<?php

use Illuminate\Support\Str;
use S4mpp\Laraguard\Routes;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Actions\View;
use S4mpp\AdminPanel\Actions\Method;
use S4mpp\AdminPanel\Resources\Read;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Navigation\Page;
use S4mpp\AdminPanel\Crud\Index;
use S4mpp\AdminPanel\Actions\Callback;
use S4mpp\AdminPanel\Actions\Prompt;
use S4mpp\AdminPanel\Crud\Create;
use S4mpp\AdminPanel\Crud\Delete;
use S4mpp\AdminPanel\Crud\Update;
use S4mpp\AdminPanel\Crud\Resource;
use S4mpp\AdminPanel\Controllers\AdminController;
use S4mpp\AdminPanel\Actions\Update as UpdateAction;
use S4mpp\AdminPanel\Controllers\SettingsController;
use S4mpp\AdminPanel\Middleware\CustomActionEnabled;
use S4mpp\AdminPanel\Controllers\CustomActionController;

$admin_panel = AdminPanel::getInstance();

$admin_panel->loadModules();

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
$route->middleware('web', 'auth:'.$guard)->group(function() use ($guard, $admin_panel)
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
	$modules = $admin_panel->getModules();
 
	foreach($modules as $module)
	{
		$routes_module = Route::prefix($module->getSlug());
		
		/*if(isset($module->roles))
		{
			$routes_module->middleware('role:'.join('|', ($module->roles ?? [])));
		}*/
		
		$routes_module->group(function() use ($module)
		{
			Route::get('/', Index::get($module))->name($module->getRouteName('index'));
	
			// if(in_array('create', $module->actions))
			// {
			// 	Route::get('/cadastrar', Create::get($module))->name($module->getRouteName('create'));
			// }

			// if(in_array('read', $module->actions))
			// {
			// 	Route::get('/visualizar/{id}', Read::get($module))->name($module->getRouteName('read'));
			// }
	
			// if(in_array('update', $module->actions))
			// {
			// 	Route::get('/editar/{id}', Update::get($module))->name($module->getRouteName('update'));
			// }
	
			// if(in_array('delete', $module->actions))
			// {
			// 	Route::delete('/excluir/{id}', Delete::delete($module))->name($module->getRouteName('delete'));
			// }

			// if(method_exists($module, 'getCustomActions'))
			// {
			// 	$custom_actions = $module->getCustomActions() ?? [];

			// 	foreach($custom_actions as $custom_action)
			// 	{
			// 		if(method_exists($custom_action, 'getCallbackRoute'))
			// 		{
			// 			$route_custom_action = Route::middleware('web');

			// 			if($permissions_custom_action = $custom_action->getPermissions())
			// 			{
			// 				$route_custom_action->middleware('can:'.join('|', $permissions_custom_action));
			// 			}

			// 			if(is_a($custom_action, Method::class))
			// 			{
			// 				$route_custom_action->middleware('custom-action-enabled:'.$module->slug.'.'.$custom_action->getSlug());
			// 			}

			// 			$route_custom_action->{$custom_action->getRouteMethod()}($custom_action->getSlug().'/{id}', $custom_action->getCallbackRoute($module))->name($custom_action->getRouteName());
			// 		}
			// 	}
			//}
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