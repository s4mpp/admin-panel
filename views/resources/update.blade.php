@extends('laraguard::layout')

@section('title', 'Editar')

@section('title-page')
	
@endsection 

@section('content')

	<div x-data="{ {{ join(', ', array_merge($data_slides ?? [], $data_search_fields ?? [])) }} }">
		@livewire('form-resource', [
			'resource_slug' => $resource->getSlug(),
			'url_to_redirect_after_save' => route($resource->getRouteName('index')),
			'register' => $register,
		])

		@foreach($repeaters ?? [] as $repeater)
			<x-element::slide-over idSlide="slide{{ $repeater->getRelation() }}" title="{{ $repeater->getTitle() }}">

				@livewire('form-repeater', [
					'resource_slug' => $resource->getSlug(),
					'repeater_slug' => $repeater->getSlug(),
				], key($repeater->getRelation()))
			</x-element::slide-over>
		@endforeach

		{{-- @foreach($search_fields ?? [] as $search)
			<x-element::modal title="Selecionar {{ Str::lower($search->getTitle()) }}" idModal="modalSearch{{ $search->getName() }}">

				<div x-data x-on:close-modal-search="modalSearch{{ $search->getName() }} = false">
					<x-element::button x-on:click="$dispatch('set-search-input', {'id': 113, 'name': 'User 1'}); $dispatch('close-modal-search')">1 - User 1</x-element::button>
					<x-element::button x-on:click="$dispatch('set-search-input')">2 - User 2</x-element::button>
					<x-element::button>3 - User 3</x-element::button>
					<x-element::button>4 - User 4</x-element::button>
				
					<hr>

					<x-admin::input-search  x-on:keyup.debounce="$dispatch('search', {q: $event.target.value}), searching=true" placeholder="Pesquisar..." />
 
					@livewire('modal-search', [
						'model' => $search->getModelName(),
						'field_to_search' => $search->getModelField(),
					], key($search->getName()))
				</div>

			</x-element::modal>
		@endforeach --}}
	</div>
@endsection