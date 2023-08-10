<?php

use S4mpp\Laraguard\Routes;
use Illuminate\Http\Request;
use S4mpp\AdminPanel\Resources\Read;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Resources\Index;
use S4mpp\AdminPanel\Resources\Create;
use S4mpp\AdminPanel\Resources\Delete;
use S4mpp\AdminPanel\Resources\Update;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Controllers\AdminController;

Route::prefix('painel')->middleware('web')->group(function()
{
	Route::controller(AdminController::class)->group(function()
	{
		Routes::authGroup();
		
		Routes::forgotAndRecoveryPasswordGroup();
	});

	$guard = config('admin.guard', 'web');

	Route::middleware('auth:'.$guard)->group(function()
	{
		Route::view('/dashboard', 'admin::dashboard')->name('dashboard_admin');
		
		$resources = Resource::getResources();

		foreach($resources as $resource)
		{
			Route::prefix($resource->name)->group(function() use ($resource)
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
			});
		}
	});
});