<?php

use S4mpp\Laraguard\Routes;
use Illuminate\Support\Facades\Route;
use S4mpp\AdminPanel\Controllers\UserController;
use S4mpp\AdminPanel\Controllers\AdminController;

Route::prefix('painel')->middleware('web')->group(function()
{
	Route::controller(AdminController::class)->group(function()
	{
		Routes::authGroup();
		
		Routes::forgotAndRecoveryPasswordGroup();
	});
	
	Route::view('/dashboard', 'admin::dashboard')->name('dashboard_admin');
	
	Route::prefix('usuarios')->controller(UserController::class)->group(function ()
	{
		Route::get('/', 'index')->name('users_index_admin');

		Route::get('/cadastrar', 'create')->name('users_create_admin');
		Route::post('/cadastrar', 'store');

		Route::get('/editar/{id}', 'edit')->name('users_edit_admin');
		Route::put('/editar/{id}', 'update');

		Route::put('/gerar-senha/{id}', 'generatePassword')->name('users_generate_password_admin');
	});
});
