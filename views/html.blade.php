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

	<style>
		[x-cloak] { display: none !important; }
	</style>
	
	@foreach($styles = config('admin.assets.css', []) as $style)
		<link rel="stylesheet" href="{{ asset($style) }}">
	@endforeach

	@if($vite_css = config('admin.vite.css'))
		@vite($vite_css)
	@endif

	@livewireStyles
</head>
<body class="h-full bg-gray-100">
	@yield('body')
	
	@livewireScripts

	@foreach($scripts = config('admin.assets.js', []) as $script)
		<script src="{{ asset($script) }}"></script> 
	@endforeach

	@if($vite_js = config('admin.vite.js'))
		@vite($vite_js)
	@endif
	
</body>
</html>