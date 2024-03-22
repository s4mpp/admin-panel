@extends('laraguard::layout')

@section('title', 'Create')

@section('content')

	<div x-data="{ {{ join(', ', array_merge($data_slides ?? [])) }} }">
		@livewire('form-resource', [
			'resource_slug' => $resource->getSlug(),
			'url_to_redirect_after_save' => route($resource->getRouteName('index'))
		])

		@foreach($repeaters ?? [] as $repeater)
			<x-element::slide-over idSlide="slide{{ $repeater->getRelation() }}" title="{{ $repeater->getTitle() }}">

				@livewire('form-repeater', [
					'resource_slug' => $resource->getSlug(),
					'repeater_slug' => $repeater->getSlug(),
				], key($repeater->getRelation()))
			</x-element::slide-over>
		@endforeach
	</div>
@endsection
