<?php

use function Orchestra\Testbench\workbench_path;

return [
	'guard' => 'web',
	
	'prefix' => 'admin',

	'route_redirect_after_login' => 'dashboard',

	'path' => workbench_path('app/AdminPanel'),
	
	'models_namespace' => '\Workbench\App\Models',

	'namespace' => 'Workbench\\App\\AdminPanel',

	'assets' => [
		'css' => ['css/style.css'],
		'js' => ['js/script.js']
	]
];