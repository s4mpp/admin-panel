<?php

return [
	'guard' => 'web',
	
	'2fa' => false,

	'prefix' => 'painel',

	'route_redirect_after_login' => 'dashboard',

	'layout_extends' => 'admin::html',

	'logo' => [
		'light' => 'images/logo_dark.png',
		'dark' => 'images/logo_dark.png'
	]
];