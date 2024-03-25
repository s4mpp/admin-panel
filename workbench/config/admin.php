<?php

use function Orchestra\Testbench\workbench_path;

return [
	'guard' => 'web',
	
	'prefix' => 'painel',

	'resources_path' => workbench_path('app/AdminPanel'),
	
	'namespace' => 'Workbench\\App',
	
	'assets' => [
		'css' => ['css/style.css'],
		'js' => ['js/script.js']
	]
];