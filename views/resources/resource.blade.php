@extends('admin::layout', ['breadcrumbs' => [
	[$title, route($resource->getRouteName('index'))],
	(isset($register) && $register) ? ['#'.$register->id, route($resource->getDefaultRoute(), ['id' => $register->id])] : null,
]])

@section('title', $title)

@section('title-page')

	@yield('title-page-resource')
	
	<x-link href="{{ route($resource->getRouteName('index')) }}" className="ring-inset ring-1 ring-gray-200 btn-muted">
	
		<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
			<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
		</svg>
	
		<span class="hidden sm:block">Voltar</span>
	</x-link>
@endsection 

@section('content')

	@yield('content-resource')
@endsection 