<?php

use function Orchestra\Testbench\workbench_path;

return [
	'guard' => 'web',
	
	'prefix' => 'painel',

	'route_redirect_after_login' => 'dashboard',

	'logo' => [
		'light' => 'images/logo_light.png',
		'dark' => 'images/logo_dark.png'
	],

	'path' => workbench_path('app/AdminPanel'),
	
	'models_namespace' => '\Workbench\App\Models',

	'namespace' => 'Workbench\\App\\AdminPanel',
];