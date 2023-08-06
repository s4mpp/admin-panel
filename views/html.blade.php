<!DOCTYPE html>
<html lang="pt-br">
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

	@vite(['resources/scss/app.scss'])
	@stack('styles')
</head>
<body class="bg-light">
	@yield('main-content')

	@vite(['resources/js/app.js'])
	@stack('scripts')
</body>
</html>