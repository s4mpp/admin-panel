<!DOCTYPE html>
<html class="h-full">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
 	<meta name="robots" content="noindex, nofollow">
	
	@hasSection('title')
		<title>{{ env('APP_NAME') }} | @yield('title')</title>
	@else
		<title>{{ env('APP_NAME') }}</title>
	@endif

	<link rel="stylesheet" href="{{ asset('vendor/laraguard/style.css') }}">
	
	<link rel="stylesheet" href="https://rsms.me/inter/inter.css">
	<link rel="stylesheet" href="{{ asset('vendor/admin-panel/style.min.css') }}">
	
	<link rel="stylesheet" href="{{ asset('vendor/element/style.css') }}">
		
	@livewireStyles
</head>
<body class="h-full bg-gray-100">
	@yield('body')

	<script src="{{ asset('vendor/admin-panel/script.min.js') }}"></script>
	@livewireScripts
</body>
</html>