<!DOCTYPE html>
<html class="h-full {{ $color ?? 'bg-white' }}">
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

	<link rel="stylesheet" href="https://rsms.me/inter/inter.css">

	@vite(['resources/scss/app.scss'])
</head>
<body class="h-full">
	@yield('main-content')

	@vite(['resources/js/app.js'])
</body>
</html>