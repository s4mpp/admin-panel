<?php

use function Orchestra\Testbench\workbench_path;

return [
	'guard' => 'web',
	
	'resources_path' => workbench_path('app/AdminPanel'),
	
	'namespace' => 'Workbench\\App',
	
	'assets' => [
		'css' => ['css/style.css'],
		'js' => ['js/script.js']
	]
];