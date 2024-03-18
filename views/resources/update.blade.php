@extends('laraguard::layout')

@section('title', 'Editar')

@section('title-page')
	
@endsection 

@section('content')

	<div x-data="{ {{ join(', ', array_merge($data_slides ?? [])) }} }">
		@livewire('form-resource', [
			'resource' => $resource,
			'register' => $register
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