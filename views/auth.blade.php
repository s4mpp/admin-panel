@extends($panel->layout()->getHtmlFile())

@php
	$logo_admin_light = config('admin.logo.light');
@endphp

@section('body')

	<div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
		<div class="sm:mx-auto sm:w-full sm:max-w-md">
			@if($logo_admin_light && file_exists($logo_admin_light))
				<img class="h-10  w-auto mx-auto" src="{{ asset($logo_admin_light) }}" alt="{{ env('APP_NAME') }}">
			@else
				<h1 class="font-bold text-lg text-center text-slate-600">{{ env('APP_NAME')  }}</h1>
			@endif
			<h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">@yield('title')</h2>
		</div>

		<div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px] ">
			<div class="bg-white px-6 py-12 shadow sm:rounded-lg sm:px-12 sm:w-full">
							
				<div class="max-w-[400px] mx-auto">
					@yield('content')
				</div>
			</div>
		</div>
	</div>
@endsection
