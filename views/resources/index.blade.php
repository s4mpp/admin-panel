@extends('admin::layout', ['breadcrumbs' => []])

@section('title', $title)

@section('title-page')
	@if(in_array('create', $resource->actions))
		<x-link href="{{ route($resource->getRouteName('create')) }}" className="btn-primary">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
			</svg>

			<span>Cadastrar</span>
		</x-link>
	@endif
@endsection

@section('content')

		<x-alert></x-alert>

	@isset($has_table)

		@livewire('table', [
			'resource_name' => $resource->name
		])
	@endisset

@endsection
